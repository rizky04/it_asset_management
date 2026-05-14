<x-tailadmin-app-layout :page="'users'">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white/90">Manajemen User</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola akun pengguna aplikasi</p>
        </div>
        <a href="{{ route('users.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path d="M12 5V19M5 12H19" stroke="white" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Tambah User
        </a>
    </div>

    @if (session('success'))
        <div class="mb-5 rounded-lg bg-success-50 border border-success-200 px-4 py-3 dark:bg-success-500/10 dark:border-success-500/20">
            <p class="text-sm font-medium text-success-600 dark:text-success-400">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-5 rounded-lg bg-error-50 border border-error-200 px-4 py-3 dark:bg-error-500/10 dark:border-error-500/20">
            <p class="text-sm font-medium text-error-600 dark:text-error-400">{{ session('error') }}</p>
        </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 overflow-hidden">

        {{-- Search toolbar --}}
        <div class="px-5 py-3.5 border-b border-gray-200 dark:border-gray-800">
            <form method="GET" action="{{ route('users.index') }}">
                <div class="relative">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-gray-400">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                            <path d="M21 21L16.514 16.506M19 10.5C19 15.194 15.194 19 10.5 19C5.806 19 2 15.194 2 10.5C2 5.806 5.806 2 10.5 2C15.194 2 19 5.806 19 10.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </span>
                    <input type="text" name="q" value="{{ $q }}"
                           placeholder="Cari nama atau email..."
                           class="h-11 w-full rounded-lg border border-gray-300 bg-transparent pl-12 pr-4 text-sm text-gray-800 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:text-white/90" />
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
                        <th class="px-4 py-4 text-center font-medium text-gray-500 dark:text-gray-400 w-12">#</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Nama</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Email</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Terdaftar</th>
                        <th class="px-4 py-4 text-left font-medium text-gray-500 dark:text-gray-400">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse ($users as $i => $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors">
                            <td class="px-4 py-3.5 text-center text-gray-400 dark:text-gray-600 tabular-nums">
                                {{ $users->firstItem() + $i }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-brand-500 text-xs font-semibold text-white uppercase">
                                        {{ mb_substr($user->name, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-800 dark:text-gray-200">{{ $user->name }}</span>
                                    @if ($user->id === auth()->id())
                                        <span class="inline-flex items-center rounded-full bg-brand-50 px-2 py-0.5 text-xs font-medium text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">Saya</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3.5 text-gray-600 dark:text-gray-400">{{ $user->email }}</td>
                            <td class="px-4 py-3.5 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-3.5">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="inline-flex items-center justify-center rounded-lg border border-gray-300 p-1.5 text-gray-500 hover:border-brand-300 hover:text-brand-500 dark:border-gray-700 dark:text-gray-400 dark:hover:border-brand-600 dark:hover:text-brand-400 transition-colors"
                                       title="Edit">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                            <path d="M11 4H4C3.46957 4 2.96086 4.21071 2.58579 4.58579C2.21071 4.96086 2 5.46957 2 6V20C2 20.5304 2.21071 21.0391 2.58579 21.4142C2.96086 21.7893 3.46957 22 4 22H18C18.5304 22 19.0391 21.7893 19.4142 21.4142C19.7893 21.0391 20 20.5304 20 20V13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M18.5 2.49998C18.8978 2.10216 19.4374 1.87866 20 1.87866C20.5626 1.87866 21.1022 2.10216 21.5 2.49998C21.8978 2.89781 22.1213 3.43737 22.1213 3.99998C22.1213 4.56259 21.8978 5.10216 21.5 5.49998L12 15L8 16L9 12L18.5 2.49998Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    @if ($user->id !== auth()->id())
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                              onsubmit="return confirm('Hapus user {{ addslashes($user->name) }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 p-1.5 text-gray-500 hover:border-error-300 hover:text-error-500 dark:border-gray-700 dark:text-gray-400 dark:hover:border-error-600 dark:hover:text-error-400 transition-colors"
                                                    title="Hapus">
                                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none">
                                                    <path d="M3 6H5H21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M8 6V4C8 3.46957 8.21071 2.96086 8.58579 2.58579C8.96086 2.21071 9.46957 2 10 2H14C14.5304 2 15.0391 2.21071 15.4142 2.58579C15.7893 2.96086 16 3.46957 16 4V6M19 6L18.1626 19.1713C18.0717 20.5059 16.9593 21.5384 15.6217 21.5384H8.37826C7.04066 21.5384 5.92832 20.5059 5.83741 19.1713L5 6H19Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-12 text-center text-gray-400 dark:text-gray-600">
                                <svg class="mx-auto mb-3 opacity-40" width="40" height="40" viewBox="0 0 24 24" fill="none">
                                    <path d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                @if ($q)
                                    Tidak ada user untuk <strong>"{{ $q }}"</strong>
                                @else
                                    Belum ada user
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-5 py-3.5 border-t border-gray-200 dark:border-gray-800">
            <p class="text-xs text-gray-500 dark:text-gray-400">
                Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} user
            </p>
            @if ($users->hasPages())
                {{ $users->links() }}
            @endif
        </div>
    </div>
</x-tailadmin-app-layout>
