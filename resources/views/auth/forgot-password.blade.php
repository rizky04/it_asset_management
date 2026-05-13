<x-tailadmin-guest-layout>
    <div class="relative p-6 bg-white z-1 dark:bg-gray-900 sm:p-0">
        <div class="relative flex flex-col justify-center w-full h-screen dark:bg-gray-900 sm:p-0 lg:flex-row">

            <!-- Form -->
            <div class="flex flex-col flex-1 w-full lg:w-1/2">
                <div class="flex flex-col justify-center flex-1 w-full max-w-md mx-auto px-6">
                    <div>
                        <!-- Back link -->
                        <div class="mb-6">
                            <a href="{{ route('login') }}" class="inline-flex items-center text-sm text-gray-500 transition-colors hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                <svg class="stroke-current mr-1" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <path d="M12.7083 5L7.5 10.2083L12.7083 15.4167" stroke="" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Kembali ke Login
                            </a>
                        </div>

                        <div class="mb-5 sm:mb-8">
                            <h1 class="mb-2 font-semibold text-gray-800 text-title-sm dark:text-white/90 sm:text-title-md">
                                Lupa Password?
                            </h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Masukkan email Anda dan kami akan mengirimkan link untuk reset password.
                            </p>
                        </div>

                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-5 rounded-lg bg-success-50 border border-success-200 px-4 py-3 dark:bg-success-500/10 dark:border-success-500/20">
                                <p class="text-sm font-medium text-success-600 dark:text-success-400">{{ session('status') }}</p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="space-y-5">

                                <!-- Email -->
                                <div>
                                    <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                        Email<span class="text-error-500">*</span>
                                    </label>
                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder="email@example.com"
                                        required
                                        autofocus
                                        autocomplete="username"
                                        class="h-11 w-full rounded-lg border {{ $errors->has('email') ? 'border-error-500' : 'border-gray-300' }} bg-transparent px-4 py-2.5 text-sm text-gray-800 shadow-theme-xs placeholder:text-gray-400 focus:border-brand-300 focus:outline-hidden focus:ring-3 focus:ring-brand-500/10 dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30 dark:focus:border-brand-800"
                                    />
                                    @error('email')
                                        <p class="mt-1 text-sm text-error-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit -->
                                <div>
                                    <button type="submit" class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-white transition rounded-lg bg-brand-500 shadow-theme-xs hover:bg-brand-600">
                                        Kirim Link Reset Password
                                    </button>
                                </div>

                            </div>
                        </form>

                        <div class="mt-5">
                            <p class="text-sm font-normal text-center text-gray-700 dark:text-gray-400 sm:text-start">
                                Ingat password Anda?
                                <a href="{{ route('login') }}" class="text-brand-500 hover:text-brand-600 dark:text-brand-400">Sign In</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Panel -->
            <div class="relative items-center hidden w-full h-full bg-brand-950 dark:bg-white/5 lg:flex lg:w-1/2 justify-center">
                <div class="flex flex-col items-center max-w-xs text-center px-8">
                    <svg class="mb-6" width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="64" height="64" rx="14" fill="#465fff"/>
                        <path d="M22 32H42M32 22V42" stroke="white" stroke-width="3.5" stroke-linecap="round"/>
                    </svg>
                    <h2 class="text-2xl font-bold text-white mb-3">{{ config('app.name', 'IT Asset') }}</h2>
                    <p class="text-gray-400 dark:text-white/60">
                        Sistem Manajemen Aset IT — kelola dan pantau aset teknologi informasi Anda dengan mudah.
                    </p>
                </div>
            </div>

            <!-- Dark Mode Toggler -->
            <div class="fixed z-50 hidden bottom-6 right-6 sm:block">
                <button class="inline-flex items-center justify-center text-white transition-colors rounded-full size-14 bg-brand-500 hover:bg-brand-600" @click.prevent="darkMode = !darkMode">
                    <svg class="hidden fill-current dark:block" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.99998 1.5415C10.4142 1.5415 10.75 1.87729 10.75 2.2915V3.5415C10.75 3.95572 10.4142 4.2915 9.99998 4.2915C9.58577 4.2915 9.24998 3.95572 9.24998 3.5415V2.2915C9.24998 1.87729 9.58577 1.5415 9.99998 1.5415ZM10.0009 6.79327C8.22978 6.79327 6.79402 8.22904 6.79402 10.0001C6.79402 11.7712 8.22978 13.207 10.0009 13.207C11.772 13.207 13.2078 11.7712 13.2078 10.0001C13.2078 8.22904 11.772 6.79327 10.0009 6.79327ZM5.29402 10.0001C5.29402 7.40061 7.40135 5.29327 10.0009 5.29327C12.6004 5.29327 14.7078 7.40061 14.7078 10.0001C14.7078 12.5997 12.6004 14.707 10.0009 14.707C7.40135 14.707 5.29402 12.5997 5.29402 10.0001Z" fill="currentColor"/>
                    </svg>
                    <svg class="fill-current dark:hidden" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.4547 11.97C16.944 11.4207 16.944 11.4207 16.944 11.4207C15.8869 12.4035 14.4721 13.0035 12.9154 13.0035C9.64678 13.0035 6.99707 10.3538 6.99707 7.08524C6.99707 5.52854 7.5971 4.11366 8.57989 3.05657C8.80718 2.81209 8.50243 1.8741 8.16227 1.73559C7.83948 1.82066 7.83948 1.82066 7.83948 1.82066C4.21532 2.77574 1.54199 6.07486 1.54199 10.0003C1.54199 14.6717 5.32892 18.4586 10.0003 18.4586C13.9257 18.4586 17.2249 15.7853 18.1799 12.1611L17.4547 11.97Z" fill="currentColor"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>
</x-tailadmin-guest-layout>
