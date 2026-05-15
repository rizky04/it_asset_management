<x-tailadmin-app-layout :page="'dashboard'">

    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Dashboard</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    {{-- Stats Cards --}}
    <div class="mb-6" style="display:grid; grid-template-columns:repeat(4,1fr); gap:1rem;">

        {{-- Total Aset --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                    <svg class="text-brand-500" width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M20 7H4C2.89543 7 2 7.89543 2 9V19C2 20.1046 2.89543 21 4 21H20C21.1046 21 22 20.1046 22 19V9C22 7.89543 21.1046 7 20 7Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M16 3H8L6 7H18L16 3Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Aset</p>
            <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($stats['total_assets']) }}</h4>
            <a href="{{ route('assets.index') }}" class="mt-2 inline-flex items-center text-xs text-brand-500 hover:text-brand-600">
                Lihat semua →
            </a>
        </div>

        {{-- Aset Rusak --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-error-50 dark:bg-error-500/10">
                    <svg class="text-error-500" width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M12 9V13M12 17H12.01M10.29 3.86L1.82 18C1.64 18.3 1.64 18.7 1.82 19C2 19.3 2.33 19.5 2.69 19.5H21.31C21.67 19.5 22 19.3 22.18 19C22.36 18.7 22.36 18.3 22.18 18L13.71 3.86C13.53 3.56 13.2 3.37 12.85 3.37C12.5 3.37 12.17 3.56 11.99 3.86H10.29Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Aset Rusak</p>
            <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($stats['broken_assets']) }}</h4>
            <a href="{{ route('assets.index') }}" class="mt-2 inline-flex items-center text-xs text-error-500 hover:text-error-600">
                Perlu perhatian →
            </a>
        </div>

        {{-- Peminjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-warning-50 dark:bg-warning-500/10">
                    <svg class="text-warning-500" width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path d="M9 14L4 9L9 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M4 9H15C17.7614 9 20 11.2386 20 14C20 16.7614 17.7614 19 15 19H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Peminjaman Aktif</p>
            <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($stats['active_lendings']) }}</h4>
            <a href="{{ route('lendings.index', ['status' => 'active']) }}" class="mt-2 inline-flex items-center text-xs text-warning-500 hover:text-warning-600">
                Lihat semua →
            </a>
        </div>

        {{-- Serah Terima --}}
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-900">
            <div class="mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-success-50 dark:bg-success-500/10">
                    <svg class="text-success-500" width="22" height="22" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7 3.25C5.20507 3.25 3.75 4.70507 3.75 6.5V17.5C3.75 19.2949 5.20507 20.75 7 20.75H17C18.7949 20.75 20.25 19.2949 20.25 17.5V6.5C20.25 4.70507 18.7949 3.25 17 3.25H7ZM5.25 6.5C5.25 5.5335 6.0335 4.75 7 4.75H17C17.9665 4.75 18.75 5.5335 18.75 6.5V17.5C18.75 18.4665 17.9665 19.25 17 19.25H7C6.0335 19.25 5.25 18.4665 5.25 17.5V6.5ZM8.25 8C8.25 7.58579 8.58579 7.25 9 7.25H15C15.4142 7.25 15.75 7.58579 15.75 8C15.75 8.41421 15.4142 8.75 15 8.75H9C8.58579 8.75 8.25 8.41421 8.25 8ZM9 10.75C8.58579 10.75 8.25 11.0858 8.25 11.5C8.25 11.9142 8.58579 12.25 9 12.25H15C15.4142 12.25 15.75 11.9142 15.75 11.5C15.75 11.0858 15.4142 10.75 15 10.75H9ZM8.25 15C8.25 14.5858 8.58579 14.25 9 14.25H12C12.4142 14.25 12.75 14.5858 12.75 15C12.75 15.4142 12.4142 15.75 12 15.75H9C8.58579 15.75 8.25 15.4142 8.25 15Z" fill="currentColor"/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Serah Terima</p>
            <h4 class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ number_format($stats['total_handovers']) }}</h4>
            <a href="{{ route('handovers.index') }}" class="mt-2 inline-flex items-center text-xs text-success-500 hover:text-success-600">
                Lihat semua →
            </a>
        </div>

    </div>

    {{-- Row 2: Kategori Aset + Peminjaman Aktif --}}
    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 mb-5">

        {{-- Ringkasan Kategori Aset --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Ringkasan Aset per Kategori</h3>
                <a href="{{ route('assets.index') }}" class="text-xs text-brand-500 hover:text-brand-600">Lihat semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-800/50">
                            <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Kategori</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400">Total</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-success-600 dark:text-success-400">Baik</th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-error-500 dark:text-error-400">Rusak</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach ($categoryStats as $row)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                                <td class="px-5 py-3">
                                    <a href="{{ route('assets.index', ['category' => $row->category]) }}"
                                       class="text-gray-700 dark:text-gray-300 hover:text-brand-500 dark:hover:text-brand-400">
                                        {{ $row->category }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-center text-gray-700 dark:text-gray-300 font-medium tabular-nums">{{ $row->total }}</td>
                                <td class="px-4 py-3 text-center text-success-600 dark:text-success-400 font-medium tabular-nums">{{ $row->good }}</td>
                                <td class="px-4 py-3 text-center font-medium tabular-nums {{ $row->broken > 0 ? 'text-error-500' : 'text-gray-300 dark:text-gray-700' }}">
                                    {{ $row->broken }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Peminjaman Aktif --}}
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
                <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Peminjaman Aktif</h3>
                <a href="{{ route('lendings.index', ['status' => 'active']) }}" class="text-xs text-brand-500 hover:text-brand-600">Lihat semua</a>
            </div>
            @if ($activelendings->isEmpty())
                <div class="px-5 py-10 text-center text-gray-400 dark:text-gray-600 text-sm">
                    Tidak ada peminjaman aktif
                </div>
            @else
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($activelendings as $lending)
                        <div class="flex items-start gap-3 px-5 py-3.5 hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full
                                {{ $lending->due_date->isPast() ? 'bg-error-50 dark:bg-error-500/10' : 'bg-warning-50 dark:bg-warning-500/10' }}">
                                <svg class="{{ $lending->due_date->isPast() ? 'text-error-500' : 'text-warning-500' }}" width="14" height="14" viewBox="0 0 24 24" fill="none">
                                    <path d="M9 14L4 9L9 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M4 9H15C17.7614 9 20 11.2386 20 14C20 16.7614 17.7614 19 15 19H12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">{{ $lending->asset->name ?? '-' }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $lending->borrower }} · {{ $lending->department }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs {{ $lending->due_date->isPast() ? 'text-error-500 font-semibold' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $lending->due_date->format('d/m/Y') }}
                                </p>
                                @if ($lending->due_date->isPast())
                                    <span class="text-xs text-error-400">Terlambat</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    {{-- Serah Terima Terbaru --}}
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white">Serah Terima Terbaru</h3>
            <a href="{{ route('handovers.index') }}" class="text-xs text-brand-500 hover:text-brand-600">Lihat semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-5 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">No. Dokumen</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Penerima</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Departemen</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Perangkat</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach ($recentHandovers as $handover)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('handovers.show', $handover) }}"
                                   class="font-mono text-xs text-brand-600 dark:text-brand-400 hover:underline">
                                    {{ $handover->doc_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400 whitespace-nowrap text-xs">
                                {{ $handover->handover_date->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3.5 text-gray-700 dark:text-gray-300">{{ $handover->to_name }}</td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 text-xs">{{ $handover->to_department ?? '-' }}</td>
                            <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400 text-xs">
                                {{ trim($handover->merek . ' ' . $handover->type_device) ?: '-' }}
                            </td>
                            <td class="px-4 py-3.5">
                                @if ($handover->isReturned())
                                    <span class="inline-flex items-center rounded-full bg-gray-100 px-2 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                        Dikembalikan
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-success-50 px-2 py-0.5 text-xs font-medium text-success-700 dark:bg-success-500/10 dark:text-success-400">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</x-tailadmin-app-layout>
