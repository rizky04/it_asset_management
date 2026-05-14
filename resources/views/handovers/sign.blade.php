@php
    $handover        = $signature->handover;
    $alphabet        = range('a', 'z');
    $city            = config('app.city', 'Surabaya');
    $company         = config('app.company', 'PT. Miracle Clinic');

    $specLabels = [
        'merek'         => 'Merek',
        'type_device'   => 'Type',
        'serial_number' => 'Serial Number',
        'processor'     => 'Processor',
        'storage'       => 'Storage',
        'ram'           => 'RAM',
        'screen_size'   => 'Ukuran Layar',
        'os'            => 'Sistem Operasi',
        'office_sw'     => 'Office',
    ];

    $specValues = [];
    foreach ($specLabels as $key => $label) {
        if (!empty($handover->$key)) {
            $specValues[$key] = ['label' => $label, 'value' => $handover->$key];
        }
    }

    $softwareList    = array_values(array_filter($handover->software_list ?? []));
    $accessoriesList = array_values(array_filter($handover->accessories_list ?? []));
    $itemLabel       = $handover->type === 'laptop' ? '1 (satu) Buah Laptop' : '1 (satu) Unit Perangkat';
    $itemNo          = 1;

    $sigLabels = \App\Models\HandoverSignature::$roleLabels;
    $signatures = $handover->signatures->keyBy('role');
    $sigRoles   = ['dept_it', 'dept_head', 'hrd', 'penerima'];
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tanda Tangan Dokumen — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/tailadmin.css') }}"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen">

{{-- ===== TOPBAR ===== --}}
<header class="sticky top-0 z-50 bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-3">
        @if (file_exists(public_path('logo.png')))
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-auto">
        @else
            <svg width="28" height="28" viewBox="0 0 32 32" fill="none"><rect width="32" height="32" rx="7" fill="#465fff"/><path d="M10 16H22M16 10V22" stroke="white" stroke-width="2.5" stroke-linecap="round"/></svg>
        @endif
        <div>
            <p class="text-sm font-semibold text-gray-800">{{ config('app.name') }}</p>
            <p class="text-xs text-gray-400">Dokumen Serah Terima</p>
        </div>
    </div>
    <div class="text-right">
        <p class="font-mono text-xs font-semibold text-brand-600">{{ $handover->doc_number }}</p>
        <p class="text-xs text-gray-400 mt-0.5">{{ $handover->handover_date->format('d/m/Y') }}</p>
    </div>
</header>

<div class="max-w-4xl mx-auto px-4 py-8">

    @if (isset($already_signed) && $already_signed)
    {{-- ===== SUDAH DITANDATANGANI ===== --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center mb-8">
        <div class="flex items-center justify-center w-14 h-14 bg-success-50 rounded-full mx-auto mb-4">
            <svg class="text-success-500" width="28" height="28" viewBox="0 0 24 24" fill="none">
                <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <h2 class="text-lg font-semibold text-gray-800 mb-1">Sudah Ditandatangani</h2>
        <p class="text-sm text-gray-500">
            <strong>{{ $signature->signer_name }}</strong> telah menandatangani dokumen ini
            pada {{ $signature->signed_at->translatedFormat('d F Y, H:i') }} WIB.
        </p>
    </div>
    @else
    {{-- ===== INFO PENANDA TANGAN ===== --}}
    <div class="bg-brand-50 border border-brand-200 rounded-2xl px-6 py-4 mb-6 flex items-start gap-3">
        <svg class="text-brand-500 mt-0.5 shrink-0" width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" stroke="currentColor" stroke-width="1.5"/>
            <path d="M12 8V12M12 16H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <div>
            <p class="text-sm font-semibold text-brand-700">Anda diminta menandatangani dokumen ini</p>
            <p class="text-sm text-brand-600 mt-0.5">
                Sebagai <strong>{{ $sigLabels[$signature->role] }}</strong> —
                silakan baca dokumen di bawah lalu tanda tangan di bagian paling bawah halaman.
            </p>
        </div>
    </div>
    @endif

    {{-- ===== DOKUMEN SURAT ===== --}}
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm mb-6">
        <div class="surat">

            {{-- LOGO --}}
            <div class="logo-area">
                @if (file_exists(public_path('logo.png')))
                    <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}" style="height: 60px; width: auto;">
                @else
                    <svg width="56" height="56" viewBox="0 0 64 64" fill="none">
                        <rect width="64" height="64" rx="12" fill="#1a7a4a"/>
                        <path d="M12 32 C16 20, 24 20, 32 32 C40 44, 48 44, 52 32" stroke="white" stroke-width="4" fill="none" stroke-linecap="round"/>
                        <text x="8" y="56" font-family="Arial" font-size="9" font-weight="bold" fill="white">MIRACLE</text>
                    </svg>
                @endif
            </div>

            {{-- GARIS --}}
            <div class="garis-header">
                <div class="garis-tebal"></div>
                <div class="garis-tipis"></div>
            </div>

            {{-- JUDUL --}}
            <h1 class="judul">SERAH TERIMA FASILITAS PERUSAHAAN</h1>

            <p class="paragraf">Yang bertandatangan dibawah ini :</p>

            {{-- PIHAK PERTAMA --}}
            <table class="tabel-pihak">
                <tr>
                    <td class="kolom-label">Nama</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->from_name }}</td>
                </tr>
                <tr>
                    <td class="kolom-label">Jabatan</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->from_position ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="kolom-label">Departemen</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->from_department ?? '-' }}</td>
                </tr>
            </table>
            <p class="paragraf">
                Dalam hal ini bertindak untuk dan atas nama <strong>{{ $company }}</strong> sesuai dengan kewenangan jabatannya yang selanjutnya disebut sebagai <strong><u>Pihak Pertama</u></strong> atau <strong><u>Yang Menyerahkan</u></strong>
            </p>

            {{-- PIHAK KEDUA --}}
            <table class="tabel-pihak">
                <tr>
                    <td class="kolom-label">Nama</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->to_name }}</td>
                </tr>
                <tr>
                    <td class="kolom-label">Jabatan</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->to_position ?? '-' }}</td>
                </tr>
                @if ($handover->to_department)
                <tr>
                    <td class="kolom-label">Departemen</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->to_department }}</td>
                </tr>
                @endif
                @if ($handover->to_address)
                <tr>
                    <td class="kolom-label">Alamat</td>
                    <td class="kolom-titik">:</td>
                    <td class="kolom-nilai">{{ $handover->to_address }}</td>
                </tr>
                @endif
            </table>
            <p class="paragraf">
                Dalam hal ini bertindak untuk dan atas nama dirinya sendiri sesuai dengan jabatan, yang selanjutnya disebut sebagai <strong><u>Pihak Kedua</u></strong> atau <strong><u>Yang Menerima.</u></strong>
            </p>

            <p class="paragraf">
                Bahwa untuk menunjang kinerja dari Pihak Kedua, maka dengan ini Pihak Pertama telah menyerahkan fasilitas perusahaan untuk digunakan oleh Pihak Kedua sesuai dengan data dibawah ini, antara Lain :
            </p>

            {{-- ITEM 1: SPESIFIKASI --}}
            <div class="item-utama">
                <p class="item-judul">{{ $itemNo }}. {{ $itemLabel }}, dengan data spesifikasi sebagai berikut :</p>
                @if (!empty($specValues))
                <table class="tabel-spek">
                    @foreach ($specValues as $i => $spec)
                    <tr>
                        <td class="spek-huruf"><strong>{{ $alphabet[array_search($i, array_keys($specValues))] }}.</strong></td>
                        <td class="spek-label">{{ $spec['label'] }}</td>
                        <td class="spek-titik">:</td>
                        <td class="spek-nilai">{{ $spec['value'] }}</td>
                    </tr>
                    @endforeach
                </table>
                @endif
            </div>
            @php $itemNo++ @endphp

            @if (count($softwareList))
            <div class="item-utama">
                <p class="item-judul">{{ $itemNo }}. Software Terinstall, antara lain :</p>
                <table class="tabel-spek">
                    @foreach ($softwareList as $si => $sw)
                    <tr>
                        <td class="spek-huruf"><strong>{{ $alphabet[$si] }}.</strong></td>
                        <td colspan="3">{{ $sw }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @php $itemNo++ @endphp
            @endif

            @if (count($accessoriesList))
            <div class="item-utama">
                <p class="item-judul">{{ $itemNo }}. Kelengkapan tambahan, antara lain :</p>
                <table class="tabel-spek">
                    @foreach ($accessoriesList as $ai => $acc)
                    <tr>
                        <td class="spek-huruf"><strong>{{ $alphabet[$ai] }}.</strong></td>
                        <td colspan="3">{{ $acc }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
            @endif

            <p class="paragraf">
                Fasilitas tersebut diserahkan oleh Pihak Pertama kepada Pihak Kedua berkaitan dengan jabatannya sebagai <strong>{{ $handover->to_position ?? $handover->to_department }}</strong>
            </p>

            <p class="paragraf">dengan dilakukannya serah terima ini maka berlaku beberapa hal yang harus diperhatikan, antara lain:</p>
            <div class="ketentuan">
                <p>1.&nbsp;&nbsp;Bahwa Fasilitas perusahaan yang diterima oleh Pihak Kedua tidak diperbolehkan untuk dipindah tangankan dan atau dilakukan pengalihan fasilitas kepada orang lain selain dan tanpa adanya persetujuan atasan dan Persetujuan Pihak Pertama.</p>
                <p>2.&nbsp;&nbsp;Bahwa Pihak Kedua bertanggung jawab secara penuh atas segala resiko yang terjadi dikarenakan timbulnya kerusakan dan atau kehilangan yang diakibatkan dari kelalaian Pihak Kedua yang dilakukan secara sengaja dan atau tidak sengaja selama penggunaan fasilitas tersebut. serta Pihak Kedua berkewajiban menanggung segala kerusakan secara pribadi seusai adanya pengecekan dari Pihak Pertama.</p>
                <p>3.&nbsp;&nbsp;Bahwa Pihak Kedua bersedia dalam berjalannya waktu penggunaan fasilitas perusahaan tersebut, untuk dapat diperiksa dan atau dilakukannya audit terkait dengan isi dan dokumen yang ada dalam fasilitas tersebut.</p>
                <p>4.&nbsp;&nbsp;Bahwa Pihak Kedua bertanggung Jawab secara penuh atas data, isi, konten dan dokumen yang berada didalam fasilitas perusahaan tersebut. Serta Pihak Kedua dilarang keras untuk menggunakan fasilitas perusahaan tersebut diluar kepentingan dan tujuan perusahaan yang dilakukan di dalam jam kerja maupun diluar jam kerja.</p>
                <p>5.&nbsp;&nbsp;Apabila Pihak Kedua sudah tidak bekerja kembali dan atau mengundurkan diri. maka Pihak Kedua berkewajiban mengembalikan fasiltas perusahaan tersebut dalam keadaan baik sebagaimana mestinya.</p>
            </div>

            <p class="paragraf">
                Demikian serah terima fasilitas perusahaan ini dibuat dan disetujui oleh PARA PIHAK dan menjadi hukum yang dapat dipertanggung jawabkan dikemudian hari.
            </p>

            <p class="tanggal-area">
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $city }},&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $handover->handover_date->format('d/m/Y') }}
            </p>

            {{-- TTD area (tampilkan yang sudah sign) --}}
            <table class="tabel-ttd">
                <tr>
                    <td colspan="2" class="ttd-group-label">Mengetahui,</td>
                    <td colspan="2" class="ttd-group-label">Menyetujui,</td>
                </tr>
                <tr>
                    @foreach ($sigRoles as $role)
                    @php $sig = $signatures[$role] ?? null @endphp
                    <td class="ttd-img-cell">
                        @if ($sig && $sig->isSigned() && $sig->signature_data)
                            <img src="{{ $sig->signature_data }}" alt="ttd" class="ttd-img">
                        @elseif ($sig && !$sig->isSigned() && $sig->role === $signature->role)
                            <div class="ttd-pending-box">← Tanda tangan Anda</div>
                        @endif
                    </td>
                    @endforeach
                </tr>
                <tr>
                    @foreach ($sigRoles as $role)
                    @php
                        $sig = $signatures[$role] ?? null;
                        $defaultName = match($role) {
                            'dept_it'   => $handover->from_name,
                            'dept_head' => $handover->dept_head ?? '___________________',
                            'hrd'       => '___________________',
                            'penerima'  => $handover->to_name,
                        };
                    @endphp
                    <td class="ttd-nama">
                        <div class="ttd-garis {{ $sig && $sig->role === $signature->role && !$sig->isSigned() ? 'ttd-active-col' : '' }}">
                            {{ $sig && $sig->isSigned() ? $sig->signer_name : $defaultName }}
                        </div>
                        <div class="ttd-role">{{ $sigLabels[$role] }}</div>
                    </td>
                    @endforeach
                </tr>
            </table>

        </div>{{-- .surat --}}
    </div>

    {{-- ===== AREA TANDA TANGAN ===== --}}
    @if (!isset($already_signed))
    <div class="bg-white rounded-2xl border-2 border-brand-200 shadow-sm overflow-hidden"
         x-data="{
             drawing: false,
             isEmpty: true,
             init() {
                 this.canvas = this.$refs.canvas;
                 this.ctx = this.canvas.getContext('2d');
                 this.ctx.strokeStyle = '#111827';
                 this.ctx.lineWidth = 2.5;
                 this.ctx.lineCap = 'round';
                 this.ctx.lineJoin = 'round';
             },
             startDraw(e) {
                 this.drawing = true;
                 this.isEmpty = false;
                 const pos = this.getPos(e);
                 this.ctx.beginPath();
                 this.ctx.moveTo(pos.x, pos.y);
             },
             draw(e) {
                 if (!this.drawing) return;
                 e.preventDefault();
                 const pos = this.getPos(e);
                 this.ctx.lineTo(pos.x, pos.y);
                 this.ctx.stroke();
             },
             stopDraw() { this.drawing = false; },
             getPos(e) {
                 const rect = this.canvas.getBoundingClientRect();
                 const scale = this.canvas.width / rect.width;
                 const src = e.touches ? e.touches[0] : e;
                 return {
                     x: (src.clientX - rect.left) * scale,
                     y: (src.clientY - rect.top) * scale
                 };
             },
             clear() {
                 this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                 this.isEmpty = true;
                 this.$refs.sigData.value = '';
             },
             submit() {
                 if (this.isEmpty) return;
                 this.$refs.sigData.value = this.canvas.toDataURL('image/png');
                 this.$refs.form.submit();
             }
         }">

        {{-- Header area TTD --}}
        <div class="px-6 py-4 border-b border-brand-100 bg-brand-50">
            <p class="text-sm font-semibold text-brand-700">Tanda Tangan Anda</p>
            <p class="text-xs text-brand-600 mt-0.5">
                Sebagai <strong>{{ $sigLabels[$signature->role] }}</strong> —
                {{ $signature->signer_name }}
            </p>
        </div>

        <div class="px-6 py-5">
            <p class="text-xs text-gray-500 mb-3">Tanda tangan di area putih di bawah ini (gunakan mouse atau jari):</p>

            {{-- Canvas --}}
            <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden"
                 style="touch-action: none;">
                <canvas x-ref="canvas"
                        width="700" height="200"
                        class="w-full cursor-crosshair block"
                        @mousedown="startDraw($event)"
                        @mousemove="draw($event)"
                        @mouseup="stopDraw()"
                        @mouseleave="stopDraw()"
                        @touchstart.prevent="startDraw($event)"
                        @touchmove.prevent="draw($event)"
                        @touchend="stopDraw()">
                </canvas>
            </div>

            <button type="button" @click="clear()"
                    class="mt-2 text-xs text-gray-400 hover:text-gray-600 transition-colors">
                ↺ Hapus &amp; Ulangi
            </button>

            <form x-ref="form" action="{{ route('sign.store', $token) }}" method="POST" class="mt-5">
                @csrf
                <input type="hidden" name="signature_data" x-ref="sigData">

                @error('signature_data')
                    <p class="mb-3 text-sm text-error-500">{{ $message }}</p>
                @enderror

                <div class="flex items-center gap-3">
                    <button type="button" @click="submit()"
                            :disabled="isEmpty"
                            :class="isEmpty
                                ? 'opacity-40 cursor-not-allowed bg-brand-500'
                                : 'bg-brand-500 hover:bg-brand-600'"
                            class="flex-1 rounded-lg px-5 py-3 text-sm font-semibold text-white transition-colors">
                        Tanda Tangani Dokumen
                    </button>
                </div>

                <p class="mt-3 text-xs text-gray-400 text-center">
                    Dengan menandatangani, Anda menyetujui seluruh isi dokumen serah terima di atas.
                </p>
            </form>
        </div>
    </div>
    @endif

</div>{{-- max-w-4xl --}}
</body>
</html>

<style>
.surat {
    font-family: 'Times New Roman', Times, serif;
    font-size: 12pt;
    line-height: 1.6;
    color: #111;
    padding: 36px 60px 48px;
}
.logo-area   { margin-bottom: 10px; }
.garis-header{ margin-bottom: 18px; }
.garis-tebal { border-top: 3px solid #111; margin-bottom: 2px; }
.garis-tipis { border-top: 1px solid #111; }
.judul {
    text-align: center;
    font-size: 13.5pt;
    font-weight: bold;
    text-decoration: underline;
    text-transform: uppercase;
    margin: 18px 0 20px;
}
.paragraf { margin: 0 0 12px; text-align: justify; }
.tabel-pihak { width: 88%; margin-left: 5%; margin-bottom: 10px; border-collapse: collapse; }
.kolom-label { width: 22%; padding: 2px 0; vertical-align: top; }
.kolom-titik { width:  5%; padding: 2px 0; vertical-align: top; text-align: center; }
.kolom-nilai { width: 73%; padding: 2px 0; vertical-align: top; }
.item-utama  { margin-left: 28px; margin-bottom: 12px; }
.item-judul  { margin: 0 0 5px; }
.tabel-spek  { width: 85%; margin-left: 36px; border-collapse: collapse; }
.spek-huruf  { width: 24px; vertical-align: top; padding: 1px 0; }
.spek-label  { width: 115px; vertical-align: top; padding: 1px 0; }
.spek-titik  { width: 18px; vertical-align: top; padding: 1px 0; text-align: center; }
.spek-nilai  { vertical-align: top; padding: 1px 0; }
.ketentuan   { margin-left: 28px; margin-bottom: 12px; }
.ketentuan p { margin-bottom: 8px; text-align: justify; }
.tanggal-area{ margin: 16px 0 20px; }
.tabel-ttd   { width: 100%; border-collapse: collapse; text-align: center; }
.ttd-group-label { text-align: left; padding-bottom: 2px; font-size: 11pt; width: 50%; }
.ttd-img-cell{ height: 70px; vertical-align: bottom; padding: 0 4px; text-align: center; }
.ttd-img     { max-height: 68px; max-width: 140px; object-fit: contain; }
.ttd-pending-box {
    height: 60px; display: flex; align-items: center; justify-content: center;
    border: 2px dashed #465fff; border-radius: 8px; color: #465fff;
    font-size: 9pt; font-family: Arial, sans-serif;
}
.ttd-nama    { width: 25%; text-align: center; padding: 0 4px; vertical-align: top; }
.ttd-garis   { border-top: 1px solid #111; padding-top: 3px; font-size: 10.5pt; }
.ttd-active-col { border-top: 2px solid #465fff; color: #465fff; }
.ttd-role    { font-size: 10pt; margin-top: 1px; }

@media (max-width: 640px) {
    .surat { padding: 24px 20px 32px; font-size: 10pt; }
    .tabel-pihak { width: 100%; margin-left: 0; }
    .tabel-spek  { width: 100%; margin-left: 8px; }
    .spek-label  { width: 90px; }
}
</style>
