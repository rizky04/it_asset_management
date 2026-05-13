<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Tanda Tangan Dokumen — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('css/tailadmin.css') }}"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="min-h-screen flex flex-col items-center justify-center px-4 py-10">

    {{-- Logo + header --}}
    <div class="mb-6 text-center">
        @if (file_exists(public_path('logo.png')))
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 mx-auto mb-3">
        @endif
        <p class="text-sm text-gray-500">{{ config('app.name') }}</p>
    </div>

    @if (isset($already_signed) && $already_signed)
        {{-- Sudah ditandatangani --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 w-full max-w-md text-center">
            <div class="flex items-center justify-center w-14 h-14 bg-success-50 rounded-full mx-auto mb-4">
                <svg class="text-success-500" width="28" height="28" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <h2 class="text-lg font-semibold text-gray-800 mb-2">Sudah Ditandatangani</h2>
            <p class="text-sm text-gray-500 mb-1">
                Dokumen ini telah ditandatangani oleh <strong>{{ $signature->signer_name }}</strong>
            </p>
            <p class="text-sm text-gray-400">{{ $signature->signed_at->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

    @else
        {{-- Form tanda tangan --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm w-full max-w-lg">

            {{-- Info dokumen --}}
            <div class="p-6 border-b border-gray-100">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Dokumen</p>
                <p class="font-semibold text-gray-800 font-mono">{{ $handover->doc_number }}</p>
                <p class="text-sm text-gray-500 mt-1">Serah Terima — {{ $handover->to_name }}</p>
            </div>

            <div class="p-6 border-b border-gray-100">
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-2">Ditandatangani Sebagai</p>
                <p class="font-semibold text-gray-800">{{ $signature->signer_name }}</p>
                <p class="text-sm text-gray-500">{{ \App\Models\HandoverSignature::$roleLabels[$signature->role] }}</p>
            </div>

            {{-- Canvas ttd --}}
            <div class="p-6" x-data="{
                drawing: false,
                isEmpty: true,
                init() {
                    this.canvas = this.$refs.canvas;
                    this.ctx = this.canvas.getContext('2d');
                    this.ctx.strokeStyle = '#111827';
                    this.ctx.lineWidth = 2;
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
                    const src = e.touches ? e.touches[0] : e;
                    return { x: src.clientX - rect.left, y: src.clientY - rect.top };
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
                <p class="text-sm font-medium text-gray-700 mb-3">Tanda tangan di sini:</p>

                <div class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 overflow-hidden"
                     style="touch-action: none;">
                    <canvas x-ref="canvas"
                            width="460" height="180"
                            class="w-full cursor-crosshair"
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

                    <button type="button" @click="submit()"
                            :disabled="isEmpty"
                            :class="isEmpty ? 'opacity-40 cursor-not-allowed' : 'hover:bg-brand-600'"
                            class="w-full rounded-lg bg-brand-500 px-5 py-3 text-sm font-semibold text-white transition-colors">
                        Tanda Tangani Dokumen
                    </button>
                </form>
            </div>

        </div>

        <p class="mt-4 text-xs text-gray-400 text-center max-w-xs">
            Dengan menandatangani, Anda menyetujui isi dokumen serah terima ini.
        </p>
    @endif

</div>
</body>
</html>
