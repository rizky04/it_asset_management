<x-tailadmin-app-layout :page="'handovers'">
    <div class="mb-6">
        <a href="{{ route('handovers.index') }}" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Kembali
        </a>
        <h2 class="mt-2 text-2xl font-semibold text-gray-800 dark:text-white/90">Buat Serah Terima</h2>
    </div>

    @if (isset($prefill))
    <div class="mb-5 rounded-xl border border-brand-200 bg-brand-50 px-5 py-3.5 dark:border-brand-800 dark:bg-brand-500/10">
        <p class="text-sm font-semibold text-brand-700 dark:text-brand-400">Serah Terima Ulang</p>
        <p class="text-sm text-brand-600 dark:text-brand-300 mt-0.5">
            Data spesifikasi dari <span class="font-mono font-semibold">{{ $prefill->doc_number }}</span> sudah terisi otomatis.
            Lengkapi data penerima baru di bagian bawah.
        </p>
    </div>
    @endif

    <form action="{{ route('handovers.store') }}" method="POST" x-data="{
        type: '{{ old('type', $prefill->type ?? 'laptop') }}',
        softwareList: {{ json_encode(old('software_list', $prefill->software_list ?? [''])) }},
        accessoriesList: {{ json_encode(old('accessories_list', $prefill->accessories_list ?? [''])) }},
        addSoftware() { this.softwareList.push('') },
        removeSoftware(i) { this.softwareList.splice(i, 1) },
        addAccessory() { this.accessoriesList.push('') },
        removeAccessory(i) { this.accessoriesList.splice(i, 1) }
    }">
        @csrf

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

            <!-- Informasi Dokumen -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Informasi Dokumen</h3>
                <div class="space-y-4">

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">No. Dokumen <span class="text-error-500">*</span></label>
                        <input type="text" name="doc_number" value="{{ old('doc_number', $docNumber) }}" required
                               class="h-11 w-full rounded-lg border {{ $errors->has('doc_number') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        @error('doc_number') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tanggal Serah Terima <span class="text-error-500">*</span></label>
                        <input type="date" name="handover_date" value="{{ old('handover_date', date('Y-m-d')) }}" required
                               class="h-11 w-full rounded-lg border {{ $errors->has('handover_date') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        @error('handover_date') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tipe <span class="text-error-500">*</span></label>
                        <select name="type" x-model="type"
                                class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                            <option value="laptop">Laptop</option>
                            <option value="add_on">Add On</option>
                        </select>
                    </div>

                </div>
            </div>

            <!-- Dari -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Diserahkan Oleh</h3>
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama <span class="text-error-500">*</span></label>
                        <input type="text" name="from_name" value="{{ old('from_name', $prefill->from_name ?? '') }}" required
                               class="h-11 w-full rounded-lg border {{ $errors->has('from_name') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        @error('from_name') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jabatan</label>
                        <input type="text" name="from_position" value="{{ old('from_position', $prefill->from_position ?? '') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Departemen</label>
                        <input type="text" name="from_department" value="{{ old('from_department', $prefill->from_department ?? '') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Kepala Departemen</label>
                        <input type="text" name="dept_head" value="{{ old('dept_head', $prefill->dept_head ?? '') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                </div>
            </div>

            <!-- Kepada -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Diterima Oleh</h3>
                <div class="space-y-4">
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Nama <span class="text-error-500">*</span></label>
                        <input type="text" name="to_name" value="{{ old('to_name') }}" required
                               class="h-11 w-full rounded-lg border {{ $errors->has('to_name') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        @error('to_name') <p class="mt-1 text-sm text-error-500">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Jabatan</label>
                        <input type="text" name="to_position" value="{{ old('to_position') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Departemen</label>
                        <input type="text" name="to_department" value="{{ old('to_department') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                    <div>
                        <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Alamat</label>
                        <input type="text" name="to_address" value="{{ old('to_address') }}"
                               class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                    </div>
                </div>
            </div>

            <!-- Spesifikasi Perangkat -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Spesifikasi Perangkat</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Label Perangkat</label>
                            <input type="text" name="device_label" value="{{ old('device_label', $prefill->device_label ?? '') }}"
                                   class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Merek</label>
                            <input type="text" name="merek" value="{{ old('merek', $prefill->merek ?? '') }}"
                                   class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Tipe Perangkat</label>
                            <input type="text" name="type_device" value="{{ old('type_device', $prefill->type_device ?? '') }}"
                                   class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Serial Number</label>
                            <input type="text" name="serial_number" value="{{ old('serial_number', $prefill->serial_number ?? '') }}"
                                   class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                        </div>
                    </div>
                    <div x-show="type === 'laptop'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Processor</label>
                                <input type="text" name="processor" value="{{ old('processor', $prefill->processor ?? '') }}"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Storage</label>
                                <input type="text" name="storage" value="{{ old('storage', $prefill->storage ?? '') }}" placeholder="128 GB SSD"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">RAM</label>
                                <input type="text" name="ram" value="{{ old('ram', $prefill->ram ?? '') }}" placeholder="8 GB"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Ukuran Layar</label>
                                <input type="text" name="screen_size" value="{{ old('screen_size', $prefill->screen_size ?? '') }}" placeholder='14"'
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Sistem Operasi</label>
                                <input type="text" name="os" value="{{ old('os', $prefill->os ?? '') }}" placeholder="Windows 11 Pro"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                            <div>
                                <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">Office / Software Utama</label>
                                <input type="text" name="office_sw" value="{{ old('office_sw', $prefill->office_sw ?? '') }}" placeholder="MS Office 2021"
                                       class="h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Software List -->
            <div x-show="type === 'laptop'" class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Daftar Software Tambahan</h3>
                <div class="space-y-2">
                    <template x-for="(item, index) in softwareList" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'software_list[' + index + ']'" x-model="softwareList[index]"
                                   placeholder="Nama software"
                                   class="h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            <button type="button" @click="removeSoftware(index)"
                                    class="flex h-11 w-11 items-center justify-center rounded-lg border border-gray-300 text-gray-400 hover:border-error-300 hover:text-error-500 dark:border-gray-700 transition-colors">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addSoftware()"
                            class="mt-2 flex items-center gap-2 text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Tambah Software
                    </button>
                </div>
            </div>

            <!-- Accessories List -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Daftar Aksesoris</h3>
                <div class="space-y-2">
                    <template x-for="(item, index) in accessoriesList" :key="index">
                        <div class="flex items-center gap-2">
                            <input type="text" :name="'accessories_list[' + index + ']'" x-model="accessoriesList[index]"
                                   placeholder="Nama aksesoris"
                                   class="h-11 flex-1 rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" />
                            <button type="button" @click="removeAccessory(index)"
                                    class="flex h-11 w-11 items-center justify-center rounded-lg border border-gray-300 text-gray-400 hover:border-error-300 hover:text-error-500 dark:border-gray-700 transition-colors">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addAccessory()"
                            class="mt-2 flex items-center gap-2 text-sm text-brand-500 hover:text-brand-600 dark:text-brand-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M12 5V19M5 12H19" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                        Tambah Aksesoris
                    </button>
                </div>
            </div>

            <!-- Catatan -->
            <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-gray-900 lg:col-span-2">
                <h3 class="mb-4 text-base font-semibold text-gray-800 dark:text-white/90">Catatan</h3>
                <textarea name="notes" rows="3" placeholder="Catatan tambahan (opsional)"
                          class="w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">{{ old('notes') }}</textarea>
            </div>

        </div>

        <div class="mt-6 flex items-center justify-end gap-3">
            <a href="{{ route('handovers.index') }}"
               class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-800 transition-colors">
                Batal
            </a>
            <button type="submit"
                    class="rounded-lg bg-brand-500 px-5 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
                Simpan Dokumen
            </button>
        </div>

    </form>
</x-tailadmin-app-layout>
