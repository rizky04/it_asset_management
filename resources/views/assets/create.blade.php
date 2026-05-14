<x-tailadmin-app-layout :page="'assets'">
    <div class="mb-6">
        <a href="{{ route('assets.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 mb-3">
            <svg class="mr-1" width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Tambah Aset</h2>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-6">
        <form method="POST" action="{{ route('assets.store') }}">
            @csrf

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                {{-- Kategori --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kategori <span class="text-error-500">*</span>
                    </label>
                    <select name="category"
                            class="h-11 w-full rounded-lg border {{ $errors->has('category') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:bg-gray-900">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama Aset --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Nama Aset <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('name') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('name')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Merek --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Merek</label>
                    <input type="text" name="brand" value="{{ old('brand') }}"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                </div>

                {{-- Kode --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kode Aset</label>
                    <input type="text" name="code" value="{{ old('code') }}"
                           class="h-11 w-full rounded-lg border {{ $errors->has('code') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('code')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Material --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Material</label>
                    <input type="text" name="material" value="{{ old('material') }}"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                </div>

                {{-- PIC --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">PIC / Pengguna</label>
                    <input type="text" name="pic" value="{{ old('pic') }}"
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                </div>

                {{-- Qty --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Jumlah <span class="text-error-500">*</span>
                    </label>
                    <input type="number" name="qty" value="{{ old('qty', 1) }}" min="0"
                           class="h-11 w-full rounded-lg border {{ $errors->has('qty') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('qty')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Good --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Kondisi Baik <span class="text-error-500">*</span>
                    </label>
                    <input type="number" name="good" value="{{ old('good', 1) }}" min="0"
                           class="h-11 w-full rounded-lg border {{ $errors->has('good') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('good')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Broken --}}
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Rusak <span class="text-error-500">*</span>
                    </label>
                    <input type="number" name="broken" value="{{ old('broken', 0) }}" min="0"
                           class="h-11 w-full rounded-lg border {{ $errors->has('broken') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90" />
                    @error('broken')
                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Flags --}}
                <div class="flex items-center gap-6 sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="for_sale" value="1" {{ old('for_sale') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
                        <span class="text-sm text-gray-700 dark:text-gray-400">Dijual</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="obsolete" value="1" {{ old('obsolete') ? 'checked' : '' }}
                               class="h-4 w-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500" />
                        <span class="text-sm text-gray-700 dark:text-gray-400">Obsolete</span>
                    </label>
                </div>

            </div>

            <div class="mt-6 flex items-center gap-3">
                <button type="submit"
                        class="inline-flex items-center justify-center rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                    Simpan Aset
                </button>
                <a href="{{ route('assets.index') }}"
                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-tailadmin-app-layout>
