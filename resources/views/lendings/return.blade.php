<x-tailadmin-app-layout :page="'lendings'">
    <div class="mb-6">
        <a href="{{ route('lendings.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-3">
            <svg class="mr-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Catat Pengembalian</h2>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6 max-w-lg">

        {{-- Info peminjaman --}}
        <div class="mb-6 rounded-xl bg-gray-50 dark:bg-gray-800/50 p-4 space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Aset</span>
                <span class="text-gray-800 dark:text-gray-200 font-medium">{{ $lending->asset->name ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Peminjam</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $lending->borrower }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Departemen</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $lending->department }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Tanggal Pinjam</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $lending->lend_date->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500 dark:text-gray-400">Batas Kembali</span>
                <span class="{{ $lending->due_date->isPast() ? 'text-error-500 font-medium' : 'text-gray-700 dark:text-gray-300' }}">
                    {{ $lending->due_date->format('d/m/Y') }}
                </span>
            </div>
        </div>

        <form method="POST" action="{{ route('lendings.return.store', $lending) }}">
            @csrf
            @method('PATCH')

            <div>
                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Tanggal Kembali <span class="text-error-500">*</span>
                </label>
                <input type="date" name="return_date" value="{{ old('return_date', now()->format('Y-m-d')) }}"
                       class="h-11 w-full rounded-lg border {{ $errors->has('return_date') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                @error('return_date')
                    <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-success-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-success-600 transition-colors">
                    Konfirmasi Pengembalian
                </button>
                <a href="{{ route('lendings.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-tailadmin-app-layout>
