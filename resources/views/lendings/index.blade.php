<x-tailadmin-app-layout :page="'lendings'">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Peminjaman Aset</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Daftar peminjaman aset IT</p>
        </div>
        <a href="{{ route('lendings.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M12 5V19M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Catat Peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg bg-success-50 border border-success-200 px-4 py-3 dark:bg-success-500/10 dark:border-success-500/20">
            <p class="text-sm font-medium text-success-600 dark:text-success-400">{{ session('success') }}</p>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">

        {{-- Toolbar --}}
        <div class="px-5 py-3.5 border-b border-gray-200 dark:border-gray-800 flex flex-col sm:flex-row gap-3">
            <form method="GET" action="{{ route('lendings.index') }}" class="flex flex-col sm:flex-row gap-3 w-full">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input type="text" name="q" value="{{ $q }}"
                           placeholder="Cari peminjam, departemen, aset..."
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-12 pr-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90" />
                </div>
                <select name="status"
                        onchange="this.form.submit()"
                        class="h-11 rounded-lg border border-gray-300 bg-transparent px-3 text-sm text-gray-700 focus:border-brand-300 focus:outline-hidden dark:border-gray-700 dark:text-white/90 dark:bg-gray-900">
                    <option value="">Semua Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Dipinjam</option>
                    <option value="returned" {{ $status === 'returned' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-4 py-4 text-center font-medium text-gray-500 dark:text-gray-400 w-12">#</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aset</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Peminjam</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Departemen</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Tgl Pinjam</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Batas Kembali</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Tgl Kembali</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Keterangan</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Status</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($lendings as $i => $lending)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-4 py-3.5 text-center text-gray-400 dark:text-gray-600 tabular-nums">
                                {{ $lendings->firstItem() + $i }}
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="text-gray-800 dark:text-gray-200 font-medium">{{ $lending->asset->name ?? '-' }}</p>
                                @if ($lending->asset?->code)
                                    <p class="text-xs font-mono text-gray-400 dark:text-gray-500">{{ $lending->asset->code }}</p>
                                @endif
                            </td>
                            <td class="px-4 py-3.5 text-gray-700 dark:text-gray-300">{{ $lending->borrower }}</td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400">{{ $lending->department }}</td>
                            <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400 whitespace-nowrap">
                                {{ $lending->lend_date->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap
                                {{ $lending->status === 'active' && $lending->due_date->isPast() ? 'text-error-500 font-medium' : 'text-gray-600 dark:text-gray-400' }}">
                                {{ $lending->due_date->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                {{ $lending->return_date ? $lending->return_date->format('d/m/Y') : '-' }}
                            </td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 text-xs max-w-[160px] truncate" title="{{ $lending->notes }}">
                                {{ $lending->notes ?: '-' }}
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($lending->status === 'returned')
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        Dikembalikan
                                    </span>
                                @elseif ($lending->due_date->isPast())
                                    <span class="inline-flex items-center rounded-full bg-error-50 px-2.5 py-0.5 text-xs font-medium text-error-600 dark:bg-error-500/10 dark:text-error-400">
                                        Terlambat
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-success-50 px-2.5 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        Dipinjam
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    @if ($lending->status === 'active')
                                        <a href="{{ route('lendings.return', $lending) }}"
                                           class="inline-flex items-center justify-center rounded-lg border border-gray-300 p-1.5 text-gray-500 hover:border-success-300 hover:text-success-500 dark:border-gray-700 dark:text-gray-400 transition-colors"
                                           title="Kembalikan">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                                <path d="M9 14L4 9L9 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M4 9H15C17.7614 9 20 11.2386 20 14C20 16.7614 17.7614 19 15 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </a>
                                    @endif
                                    <a href="{{ route('lendings.edit', $lending) }}"
                                       class="inline-flex items-center justify-center rounded-lg border border-gray-300 p-1.5 text-gray-500 hover:border-brand-300 hover:text-brand-500 dark:border-gray-700 dark:text-gray-400 transition-colors"
                                       title="Edit">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5 2.49998C18.8978 2.10216 19.4374 1.87866 20 1.87866C20.5626 1.87866 21.1022 2.10216 21.5 2.49998C21.8978 2.89781 22.1213 3.43737 22.1213 3.99998C22.1213 4.56259 21.8978 5.10216 21.5 5.49998L12 15L8 16L9 12L18.5 2.49998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    <form action="{{ route('lendings.destroy', $lending) }}" method="POST"
                                          onsubmit="return confirm('Hapus data peminjaman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 p-1.5 text-gray-500 hover:border-error-300 hover:text-error-500 dark:border-gray-700 dark:text-gray-400 transition-colors"
                                                title="Hapus">
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                                <path d="M3 6H5H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6L18.1626 19.1713C18.0717 20.5059 16.9593 21.5384 15.6217 21.5384H8.37826C7.04066 21.5384 5.92832 20.5059 5.83741 19.1713L5 6H19Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-5 py-12 text-center text-gray-400 dark:text-gray-600">
                                <svg class="mx-auto mb-3 opacity-40" width="40" height="40" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="1.5"/>
                                    <path d="M16 3H8L6 7H18L16 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @if ($q || $status)
                                    Tidak ada hasil untuk filter yang dipilih
                                @else
                                    Belum ada data peminjaman
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-5 py-3.5 border-t border-gray-200 dark:border-gray-800">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Menampilkan {{ $lendings->firstItem() ?? 0 }}–{{ $lendings->lastItem() ?? 0 }} dari {{ $lendings->total() }} data
            </p>
            @if ($lendings->hasPages())
                {{ $lendings->links() }}
            @endif
        </div>
    </div>
</x-tailadmin-app-layout>
