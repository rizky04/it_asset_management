<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tanda Tangan Berhasil — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/tailadmin.css') }}"/>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center px-4">

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-10 w-full max-w-md text-center">
    @if (file_exists(public_path('logo.png')))
        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10 mx-auto mb-6">
    @endif

    <div class="flex items-center justify-center w-16 h-16 bg-success-50 rounded-full mx-auto mb-5">
        <svg class="text-success-500" width="32" height="32" viewBox="0 0 24 24" fill="none">
            <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </div>

    <h2 class="text-xl font-bold text-gray-800 mb-2">Tanda Tangan Berhasil!</h2>
    <p class="text-sm text-gray-500 mb-1">
        <strong>{{ $signature->signer_name }}</strong> telah menandatangani dokumen
    </p>
    <p class="font-mono text-sm text-brand-600 mb-1">{{ $signature->handover->doc_number }}</p>
    <p class="text-xs text-gray-400">{{ $signature->signed_at->translatedFormat('d F Y, H:i') }} WIB</p>

    <div class="mt-6 pt-6 border-t border-gray-100">
        <p class="text-xs text-gray-400">Halaman ini bisa ditutup.</p>
    </div>
</div>

</body>
</html>
