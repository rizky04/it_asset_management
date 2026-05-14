<x-tailadmin-app-layout :page="'lendings'">
    <div class="mb-6">
        <a href="{{ route('lendings.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-3">
            <svg class="mr-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Edit Peminjaman</h2>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <form method="POST" action="{{ route('lendings.update', $lending) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Aset --}}
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Aset <span class="text-error-500">*</span>
                    </label>
                    <select name="asset_id"
                            class="h-11 w-full rounded-lg border {{ $errors->has('asset_id') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:bg-gray-900">
                        <option value="">-- Pilih Aset --</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id', $lending->asset_id) == $asset->id ? 'selected' : '' }}>
                                [{{ $asset->category }}] {{ $asset->name }}{{ $asset->code ? ' — ' . $asset->code : '' }}{{ $asset->brand ? ' (' . $asset->brand . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('asset_id')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Peminjam --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Peminjam <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="borrower" value="{{ old('borrower', $lending->borrower) }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('borrower') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('borrower')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Departemen --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Departemen <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="department" value="{{ old('department', $lending->department) }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('department') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('department')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Pinjam --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Tanggal Pinjam <span class="text-error-500">*</span>
                    </label>
                    <input type="date" name="lend_date" value="{{ old('lend_date', $lending->lend_date->format('Y-m-d')) }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('lend_date') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('lend_date')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Batas Kembali --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Batas Pengembalian <span class="text-error-500">*</span>
                    </label>
                    <input type="date" name="due_date" value="{{ old('due_date', $lending->due_date->format('Y-m-d')) }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('due_date') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('due_date')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Kembali --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Kembali</label>
                    <input type="date" name="return_date" value="{{ old('return_date', $lending->return_date?->format('Y-m-d')) }}"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                </div>

                {{-- Status --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Status</label>
                    <select name="status"
                            class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:bg-gray-900">
                        <option value="active" {{ old('status', $lending->status) === 'active' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="returned" {{ old('status', $lending->status) === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                    </select>
                </div>

                {{-- Keterangan --}}
                <div class="sm:col-span-2">
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Keterangan</label>
                    <textarea name="notes" rows="3"
                              class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90">{{ old('notes', $lending->notes) }}</textarea>
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Simpan Perubahan
                </button>
                <a href="{{ route('lendings.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-tailadmin-app-layout>
