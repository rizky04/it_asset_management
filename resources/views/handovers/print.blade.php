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

    $sigRoles  = ['dept_it', 'dept_head', 'hrd', 'penerima'];
    $sigLabels = \App\Models\HandoverSignature::$roleLabels;
    $signatures = $handover->signatures->keyBy('role');
@endphp
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{ $handover->doc_number }} — Serah Terima</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 12pt;
            line-height: 1.6;
            color: #111;
            background: white;
        }

        .surat {
            width: 21cm;
            min-height: 29.7cm;
            margin: 0 auto;
            padding: 2cm 2.5cm;
            background: white;
        }

        /* Logo */
        .logo-area { margin-bottom: 10px; }
        .logo-area img { height: 60px; width: auto; }

        /* Garis */
        .garis-tebal { border-top: 3px solid #111; margin-bottom: 2px; }
        .garis-tipis { border-top: 1px solid #111; margin-bottom: 18px; }

        /* Judul */
        h1.judul {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 18px 0 20px;
            color: #111;
        }

        /* Paragraf */
        p.paragraf { margin: 0 0 12px; text-align: justify; color: #111; }

        /* Tabel pihak */
        table.tabel-pihak {
            width: 88%;
            margin-left: 5%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .kolom-label { width: 22%; padding: 2px 0; vertical-align: top; color: #111; }
        .kolom-titik { width:  5%; padding: 2px 0; vertical-align: top; text-align: center; color: #111; }
        .kolom-nilai { width: 73%; padding: 2px 0; vertical-align: top; color: #111; }

        /* Items */
        .item-utama { margin-left: 28px; margin-bottom: 12px; }
        .item-judul { margin: 0 0 5px; color: #111; }

        table.tabel-spek {
            width: 85%;
            margin-left: 36px;
            border-collapse: collapse;
        }
        .spek-huruf { width: 24px;  vertical-align: top; padding: 1px 0; color: #111; font-weight: bold; }
        .spek-label { width: 115px; vertical-align: top; padding: 1px 0; color: #111; }
        .spek-titik { width: 18px;  vertical-align: top; padding: 1px 0; text-align: center; color: #111; }
        .spek-nilai { vertical-align: top; padding: 1px 0; color: #111; }

        /* Ketentuan */
        .ketentuan { margin-left: 28px; margin-bottom: 12px; }
        .ketentuan p { margin-bottom: 8px; text-align: justify; color: #111; }

        /* Tanggal */
        .tanggal-area { margin: 16px 0 20px; color: #111; }

        /* TTD */
        table.tabel-ttd { width: 100%; border-collapse: collapse; text-align: center; }
        .ttd-group-label { text-align: left; padding-bottom: 4px; font-size: 11pt; width: 50%; color: #111; }
        .ttd-img-cell    { height: 75px; vertical-align: bottom; padding: 0 4px; text-align: center; }
        .ttd-img         { max-height: 70px; max-width: 140px; object-fit: contain; }
        .ttd-nama        { width: 25%; text-align: center; padding: 0 4px; vertical-align: top; }
        .ttd-garis       { border-top: 1px solid #111; padding-top: 3px; font-size: 10.5pt; color: #111; }
        .ttd-role        { font-size: 10pt; margin-top: 1px; color: #111; }

        strong, u, b { color: #111; }

        @media print {
            @page { size: A4 portrait; margin: 2cm 2.5cm; }
            body  { margin: 0; padding: 0; }
            .surat { width: 100%; padding: 0; margin: 0; }
        }
    </style>
</head>
<body onload="window.print()">
<div class="surat">

    {{-- LOGO --}}
    <div class="logo-area">
        @if (file_exists(public_path('logo.png')))
            <img src="{{ asset('logo.png') }}" alt="{{ config('app.name') }}">
        @endif
    </div>

    {{-- GARIS --}}
    <div class="garis-tebal"></div>
    <div class="garis-tipis"></div>

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
                <td class="spek-huruf">{{ $alphabet[array_search($i, array_keys($specValues))] }}.</td>
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
                <td class="spek-huruf">{{ $alphabet[$si] }}.</td>
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
                <td class="spek-huruf">{{ $alphabet[$ai] }}.</td>
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

    {{-- TANGGAL --}}
    <p class="tanggal-area">
        &nbsp;&nbsp;&nbsp;&nbsp;{{ $city }},&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $handover->handover_date->format('d/m/Y') }}
    </p>

    {{-- TTD --}}
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
                    'hrd'       => $handover->hrd_name ?? '___________________',
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

</div>
</body>
</html>
