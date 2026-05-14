@php
    $alphabet = range('a', 'z');
    $city     = config('app.city', 'Surabaya');
    $company  = config('app.company', 'PT. Miracle Clinic');

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

    $sigRoles = ['dept_it', 'dept_head', 'hrd', 'penerima'];
    $sigLabels = \App\Models\HandoverSignature::$roleLabels;
    $signatures = $handover->signatures->keyBy('role');
    $hasSignatures = $handover->signatures->isNotEmpty();
    $allSigned = $hasSignatures && $handover->signatures->every(fn($s) => $s->isSigned());
@endphp

<x-tailadmin-app-layout :page="'handovers'">

    {{-- Toolbar --}}
    <div class="mb-6 flex items-center justify-between no-print">
        <div>
            <a href="{{ route('handovers.index') }}"
               class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali
            </a>
            <div class="mt-2 flex items-center gap-3">
                <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Detail Serah Terima</h2>
                @if ($handover->isReturned())
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                        Dikembalikan
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-3 py-1 text-xs font-semibold text-success-600 dark:bg-success-500/10 dark:text-success-400">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="currentColor"><circle cx="5" cy="5" r="5"/></svg>
                        Aktif
                    </span>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-2">
            @if (session('success'))
                <span class="text-sm font-medium text-success-600">{{ session('success') }}</span>
            @endif

            {{-- Tombol kontekstual berdasarkan status --}}
            @if ($handover->isReturned())
                {{-- Sudah dikembalikan: tawarkan serah terima ulang --}}
                <a href="{{ route('handovers.redispatch', $handover) }}"
                   class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M4 12V9C4 7.9 4.9 7 6 7H20M20 7L17 4M20 7L17 10" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 12V15C20 16.1 19.1 17 18 17H4M4 17L7 20M4 17L7 14" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Serah Terima Ulang
                </a>
            @else
                {{-- Masih aktif: bisa kembalikan, edit, cetak --}}
                <a href="{{ route('handovers.return', $handover) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M9 15L3 9M3 9L9 3M3 9H15C16.6 9 18 9.7 19 10.8C20 11.9 20.5 13.4 20.5 15C20.5 18.6 17.6 21.5 14 21.5H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Kembalikan
                </a>
                <a href="{{ route('handovers.edit', $handover) }}"
                   class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                        <path d="M11 4H4C3.47 4 2.96 4.21 2.59 4.59C2.21 4.96 2 5.47 2 6V20C2 20.53 2.21 21.04 2.59 21.41C2.96 21.79 3.47 22 4 22H18C18.53 22 19.04 21.79 19.41 21.41C19.79 21.04 20 20.53 20 20V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M18.5 2.5C18.9 2.1 19.44 1.88 20 1.88C20.56 1.88 21.1 2.1 21.5 2.5C21.9 2.9 22.12 3.44 22.12 4C22.12 4.56 21.9 5.1 21.5 5.5L12 15L8 16L9 12L18.5 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    Edit
                </a>
            @endif

            <a href="{{ route('handovers.print', $handover) }}" target="_blank"
               class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors {{ $handover->isReturned() ? 'hidden' : '' }}">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                    <path d="M6 9V2H18V9" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M6 18H4C3.47 18 2.96 17.79 2.59 17.41C2.21 17.04 2 16.53 2 16V11C2 10.47 2.21 9.96 2.59 9.59C2.96 9.21 3.47 9 4 9H20C20.53 9 21.04 9.21 21.41 9.59C21.79 9.96 22 10.47 22 11V16C22 16.53 21.79 17.04 21.41 17.41C21.04 17.79 20.53 18 20 18H18" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M18 14H6V22H18V14Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Cetak
            </a>
        </div>
    </div>

    {{-- ================== PANEL TANDA TANGAN (no-print) ================== --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 no-print">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-base font-semibold text-gray-800 dark:text-white/90">Tanda Tangan Digital</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Bagikan link ke masing-masing penanda tangan</p>
            </div>
            @if (!$hasSignatures)
                <form action="{{ route('handovers.signatures.generate', $handover) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M12 5V19M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Buat Link Tanda Tangan
                    </button>
                </form>
            @endif
        </div>

        @if ($hasSignatures)
        <div class="divide-y divide-gray-100 dark:divide-gray-800">
            @foreach ($sigRoles as $role)
                @php $sig = $signatures[$role] ?? null @endphp
                <div class="flex items-center gap-4 px-6 py-4">
                    {{-- Status badge --}}
                    <div class="shrink-0">
                        @if ($sig && $sig->isSigned())
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-success-50 px-2.5 py-1 text-xs font-medium text-success-600 dark:bg-success-500/10 dark:text-success-400">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Ditandatangani
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5"/><path d="M12 7V12L15 15" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                Menunggu
                            </span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $sig->signer_name ?? $sigLabels[$role] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $sigLabels[$role] }}</p>
                        @if ($sig && $sig->isSigned())
                            <p class="text-xs text-success-500 mt-0.5">{{ $sig->signed_at->translatedFormat('d M Y, H:i') }} WIB</p>
                        @endif
                    </div>

                    {{-- Actions --}}
                    @if ($sig)
                    <div class="flex items-center gap-2 shrink-0" x-data="{ copied: false }">
                        @if (!$sig->isSigned())
                            {{-- Copy link --}}
                            <button type="button"
                                    @click="
                                        navigator.clipboard.writeText('{{ route('sign', $sig->token) }}');
                                        copied = true;
                                        setTimeout(() => copied = false, 2000)
                                    "
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 hover:border-brand-300 hover:text-brand-600 dark:border-gray-700 dark:text-gray-400 transition-colors">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M8 5H6C4.9 5 4 5.9 4 7V19C4 20.1 4.9 21 6 21H18C19.1 21 20 20.1 20 19V7C20 5.9 19.1 5 18 5H16M8 5C8 5.55 8.45 6 9 6H15C15.55 6 16 5.55 16 5M8 5C8 4.45 8.45 4 9 4H15C15.55 4 16 4.45 16 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                <span x-text="copied ? 'Tersalin!' : 'Salin Link'"></span>
                            </button>

                            {{-- Open link --}}
                            <a href="{{ route('sign', $sig->token) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-600 hover:border-brand-300 hover:text-brand-600 dark:border-gray-700 dark:text-gray-400 transition-colors">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M18 13V19C18 19.53 17.79 20.04 17.41 20.41C17.04 20.79 16.53 21 16 21H5C4.47 21 3.96 20.79 3.59 20.41C3.21 20.04 3 19.53 3 19V8C3 7.47 3.21 6.96 3.59 6.59C3.96 6.21 4.47 6 5 6H11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><path d="M15 3H21V9M10 14L21 3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Buka
                            </a>
                        @endif

                        @if ($sig->isSigned())
                            {{-- Reset --}}
                            <form action="{{ route('handovers.signatures.reset', [$handover, $role]) }}" method="POST"
                                  onsubmit="return confirm('Reset tanda tangan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 px-3 py-1.5 text-xs font-medium text-gray-500 hover:border-error-300 hover:text-error-500 dark:border-gray-700 transition-colors">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M3 6H5H21M19 6L18.16 19.17C18.07 20.51 16.96 21.54 15.62 21.54H8.38C7.04 21.54 5.93 20.51 5.84 19.17L5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                                    Reset
                                </button>
                            </form>
                        @endif
                    </div>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($allSigned)
        <div class="px-6 py-3 bg-success-50 dark:bg-success-500/10 rounded-b-2xl border-t border-success-100 dark:border-success-500/20">
            <p class="text-xs font-medium text-success-600 dark:text-success-400">
                ✓ Semua pihak telah menandatangani dokumen ini
            </p>
        </div>
        @endif
        @else
        <div class="px-6 py-8 text-center text-sm text-gray-400">
            Klik "Buat Link Tanda Tangan" untuk generate link TTD bagi semua pihak.
        </div>
        @endif
    </div>

    {{-- ================== DOKUMEN SURAT ================== --}}
    <div id="doc" class="bg-white rounded-2xl border border-gray-200 dark:border-gray-800 dark:bg-gray-900">
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

            {{-- GARIS HEADER --}}
            <div class="garis-header">
                <div class="garis-tebal"></div>
                <div class="garis-tipis"></div>
            </div>

            {{-- JUDUL --}}
            <h1 class="judul">SERAH TERIMA FASILITAS PERUSAHAAN</h1>

            {{-- PEMBUKA --}}
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

            {{-- ITEM 2: SOFTWARE --}}
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

            {{-- ITEM 3: KELENGKAPAN --}}
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

            {{-- KETENTUAN --}}
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

            {{-- TANGGAL --}}
            <p class="tanggal-area">
                &nbsp;&nbsp;&nbsp;&nbsp;{{ $city }},&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $handover->handover_date->format('d/m/Y') }}
            </p>

            {{-- MENGETAHUI / MENYETUJUI label --}}
            <table class="tabel-ttd">
                <tr>
                    <td colspan="2" class="ttd-group-label">Mengetahui,</td>
                    <td colspan="2" class="ttd-group-label">Menyetujui,</td>
                </tr>

                {{-- Gambar tanda tangan (jika ada) --}}
                <tr>
                    @foreach ($sigRoles as $role)
                    @php $sig = $signatures[$role] ?? null @endphp
                    <td class="ttd-img-cell">
                        @if ($sig && $sig->isSigned() && $sig->signature_data)
                            <img src="{{ $sig->signature_data }}" alt="ttd" class="ttd-img">
                        @endif
                    </td>
                    @endforeach
                </tr>

                {{-- Garis + nama --}}
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
                        <div class="ttd-garis">{{ $sig && $sig->isSigned() ? $sig->signer_name : $defaultName }}</div>
                        <div class="ttd-role">{{ $sigLabels[$role] }}</div>
                    </td>
                    @endforeach
                </tr>
            </table>

        </div>{{-- .surat --}}
    </div>{{-- #doc --}}

</x-tailadmin-app-layout>

<style>
/* ===== DOKUMEN SURAT ===== */
.surat {
    font-family: 'Times New Roman', Times, serif;
    font-size: 12pt;
    line-height: 1.6;
    color: #111;
    padding: 36px 60px 48px;
    max-width: 794px;
    margin: 0 auto;
}
.logo-area  { margin-bottom: 10px; }
.garis-header { margin-bottom: 18px; }
.garis-tebal  { border-top: 3px solid #111; margin-bottom: 2px; }
.garis-tipis  { border-top: 1px solid #111; }

.judul {
    text-align: center;
    font-size: 13.5pt;
    font-weight: bold;
    text-decoration: underline;
    text-transform: uppercase;
    margin: 18px 0 20px;
    letter-spacing: 0.3px;
}
.paragraf { margin: 0 0 12px; text-align: justify; }

/* Tabel pihak */
.tabel-pihak { width: 88%; margin-left: 5%; margin-bottom: 10px; border-collapse: collapse; }
.kolom-label { width: 22%; padding: 2px 0; vertical-align: top; }
.kolom-titik { width:  5%; padding: 2px 0; vertical-align: top; text-align: center; }
.kolom-nilai { width: 73%; padding: 2px 0; vertical-align: top; }

/* Items */
.item-utama  { margin-left: 28px; margin-bottom: 12px; }
.item-judul  { margin: 0 0 5px; }
.tabel-spek  { width: 85%; margin-left: 36px; border-collapse: collapse; }
.spek-huruf  { width: 24px; vertical-align: top; padding: 1px 0; }
.spek-label  { width: 115px; vertical-align: top; padding: 1px 0; }
.spek-titik  { width: 18px;  vertical-align: top; padding: 1px 0; text-align: center; }
.spek-nilai  { vertical-align: top; padding: 1px 0; }

/* Ketentuan */
.ketentuan      { margin-left: 28px; margin-bottom: 12px; }
.ketentuan p    { margin-bottom: 8px; text-align: justify; }

/* Tanggal */
.tanggal-area { margin: 16px 0 20px; }

/* TTD */
.tabel-ttd      { width: 100%; border-collapse: collapse; text-align: center; }
.ttd-group-label{ text-align: left; padding-bottom: 2px; font-size: 11pt; width: 50%; }
.ttd-img-cell   { height: 70px; vertical-align: bottom; padding: 0 4px; text-align: center; }
.ttd-img        { max-height: 68px; max-width: 140px; object-fit: contain; }
.ttd-nama       { width: 25%; text-align: center; padding: 0 4px; vertical-align: top; }
.ttd-garis      { border-top: 1px solid #111; padding-top: 3px; font-size: 10.5pt; }
.ttd-role       { font-size: 10pt; margin-top: 1px; }

/* Dark mode */
.dark .surat, .dark .garis-tebal, .dark .garis-tipis,
.dark .ttd-garis { color: #e5e7eb; border-color: #e5e7eb; }

/* ===== PRINT ===== */
@media print {
    /* Sembunyikan UI, biarkan konten mengalir */
    .no-print { display: none !important; }
    aside     { display: none !important; }
    header    { display: none !important; }

    /* Lepas constraint layout TailAdmin agar dokumen bisa dicetak */
    body,
    html,
    body > div,
    body > div > div,
    body > div > div > div,
    main {
        display: block !important;
        height: auto !important;
        min-height: 0 !important;
        overflow: visible !important;
        background: white !important;
        width: 100% !important;
        padding: 0 !important;
        margin: 0 !important;
        flex: none !important;
    }

    /* Paksa semua teks di dokumen hitam */
    .surat, .surat * {
        color: #111 !important;
        background: transparent !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        text-decoration-color: #111 !important;
    }

    .garis-tebal { border-top: 3px solid #111 !important; }
    .garis-tipis { border-top: 1px solid #111 !important; }
    .ttd-garis   { border-top: 1px solid #111 !important; }

    #doc {
        border: none !important;
        box-shadow: none !important;
        border-radius: 0 !important;
        display: block !important;
    }

    .surat { padding: 0 !important; max-width: 100% !important; }

    @page { size: A4 portrait; margin: 2cm 2.5cm; }
}
</style>
