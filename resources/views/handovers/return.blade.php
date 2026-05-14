<x-tailadmin-app-layout :page="'handovers'">

    <div class="mb-6">
        <a href="{{ route('handovers.show', $handover) }}"
           class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h2 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white/90">Catat Pengembalian</h2>
    </div>

    {{-- Info laptop --}}
    <div class="mb-6 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-5">
        <p class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-3">Laptop yang Dikembalikan</p>
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">
            <div>
                <p class="text-xs text-gray-400">No. Dokumen</p>
                <p class="text-sm font-semibold font-mono text-brand-600 dark:text-brand-400">{{ $handover->doc_number }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Pemegang</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $handover->to_name }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Perangkat</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $handover->merek }} {{ $handover->type_device }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-400">Serial Number</p>
                <p class="text-sm font-medium text-gray-800 dark:text-white/90">{{ $handover->serial_number ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Form --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <form action="{{ route('handovers.return.store', $handover) }}" method="POST">
            @csrf
            <div class="grid gap-5 sm:grid-cols-2">

                {{-- Dikembalikan oleh --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Dikembalikan Oleh <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="returned_by"
                           value="{{ old('returned_by', $handover->to_name) }}"
                           placeholder="Nama pemegang laptop"
                           class="h-11 w-full rounded-lg border {{ $errors->has('returned_by') ? 'border-error-500' : 'border-gray-300 dark:border-gray-700' }} bg-transparent px-4 text-sm text-gray-800 dark:text-white/90 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10"/>
                    @error('returned_by')
                        <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal pengembalian --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Pengembalian <span class="text-error-500">*</span>
                    </label>
                    <input type="date" name="returned_at"
                           value="{{ old('returned_at', now()->format('Y-m-d')) }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('returned_at') ? 'border-error-500' : 'border-gray-300 dark:border-gray-700' }} bg-transparent px-4 text-sm text-gray-800 dark:text-white/90 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10"/>
                    @error('returned_at')
                        <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Catatan Kondisi
                    </label>
                    <textarea name="return_notes" rows="3"
                              placeholder="Contoh: kondisi baik, charger lengkap / ada goresan di bagian bawah, charger tidak dikembalikan..."
                              class="w-full rounded-lg border {{ $errors->has('return_notes') ? 'border-error-500' : 'border-gray-300 dark:border-gray-700' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 dark:text-white/90 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10">{{ old('return_notes') }}</textarea>
                    @error('return_notes')
                        <p class="mt-1 text-xs text-error-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 transition-colors">
                    Konfirmasi Pengembalian
                </button>
                <a href="{{ route('handovers.show', $handover) }}"
                   class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

</x-tailadmin-app-layout>
