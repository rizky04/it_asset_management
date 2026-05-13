<x-tailadmin-app-layout>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Dashboard</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Selamat datang, {{ Auth::user()->name }}!</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4 md:gap-6 mb-6">

        <!-- Card 1 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-brand-50 dark:bg-brand-500/10">
                    <svg class="fill-brand-500" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 5.5C3.25 4.25736 4.25736 3.25 5.5 3.25H18.5C19.7426 3.25 20.75 4.25736 20.75 5.5V18.5C20.75 19.7426 19.7426 20.75 18.5 20.75H5.5C4.25736 20.75 3.25 19.7426 3.25 18.5V5.5ZM5.5 4.75C5.08579 4.75 4.75 5.08579 4.75 5.5V8.58325L19.25 8.58325V5.5C19.25 5.08579 18.9142 4.75 18.5 4.75H5.5ZM19.25 10.0833H15.416V13.9165H19.25V10.0833ZM13.916 10.0833L10.083 10.0833V13.9165L13.916 13.9165V10.0833ZM8.58301 10.0833H4.75V13.9165H8.58301V10.0833ZM4.75 18.5V15.4165H8.58301V19.25H5.5C5.08579 19.25 4.75 18.9142 4.75 18.5ZM10.083 19.25V15.4165L13.916 15.4165V19.25H10.083ZM15.416 19.25V15.4165H19.25V18.5C19.25 18.9142 18.9142 19.25 18.5 19.25H15.416Z" fill=""/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Total Aset</p>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">0</h4>
        </div>

        <!-- Card 2 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-success-50 dark:bg-success-500/10">
                    <svg class="fill-success-500" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 3.5C7.30558 3.5 3.5 7.30558 3.5 12C3.5 16.6944 7.30558 20.5 12 20.5C16.6944 20.5 20.5 16.6944 20.5 12C20.5 7.30558 16.6944 3.5 12 3.5ZM2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12ZM16.7179 9.81932C17.0108 9.52643 17.0108 9.05155 16.7179 8.75866C16.425 8.46577 15.9501 8.46577 15.6573 8.75866L10.6112 13.8047L8.33208 11.5256C8.03919 11.2327 7.56432 11.2327 7.27142 11.5256C6.97853 11.8185 6.97853 12.2934 7.27142 12.5863L10.0805 15.3953C10.3734 15.6882 10.8483 15.6882 11.1412 15.3953L16.7179 9.81932Z" fill=""/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Aset Aktif</p>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">0</h4>
        </div>

        <!-- Card 3 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-warning-50 dark:bg-warning-500/10">
                    <svg class="fill-warning-500" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M9.44829 4.46472C10.5836 2.51208 13.4164 2.51208 14.5517 4.46472L20.8648 15.0498C22.0064 17.0119 20.5831 19.5 18.313 19.5H5.68696C3.41686 19.5 1.99355 17.0119 3.1352 15.0498L9.44829 4.46472ZM11.9998 8.25C12.4141 8.25 12.7498 8.58579 12.7498 9V13C12.7498 13.4142 12.4141 13.75 11.9998 13.75C11.5856 13.75 11.2498 13.4142 11.2498 13V9C11.2498 8.58579 11.5856 8.25 11.9998 8.25ZM11.9998 16.75C12.4141 16.75 12.7498 16.4142 12.7498 16C12.7498 15.5858 12.4141 15.25 11.9998 15.25C11.5856 15.25 11.2498 15.5858 11.2498 16C11.2498 16.4142 11.5856 16.75 11.9998 16.75Z" fill=""/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Perlu Perawatan</p>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">0</h4>
        </div>

        <!-- Card 4 -->
        <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-white/[0.03]">
            <div class="flex items-center justify-between mb-4">
                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-error-50 dark:bg-error-500/10">
                    <svg class="fill-error-500" width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M5.63604 5.63604C9.15076 2.12132 14.8492 2.12132 18.364 5.63604C21.8787 9.15076 21.8787 14.8492 18.364 18.364C14.8492 21.8787 9.15076 21.8787 5.63604 18.364C2.12132 14.8492 2.12132 9.15076 5.63604 5.63604ZM17.0533 6.94673C14.3166 4.21001 9.91035 4.03612 6.96878 6.42508L17.5754 17.0317C19.9644 14.0901 19.7905 9.6839 17.0533 6.94673ZM16.9571 17.7382L6.26282 7.04393C3.82516 10.0174 4.04041 14.4869 6.94673 17.3932C9.85305 20.2996 14.3226 20.5148 17.296 18.0772L16.9571 17.7382Z" fill=""/>
                    </svg>
                </span>
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400">Tidak Aktif</p>
            <h4 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">0</h4>
        </div>

    </div>

    <!-- Welcome Card -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 dark:border-gray-800 dark:bg-white/[0.03]">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Selamat Datang di IT Asset Management</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Sistem ini membantu Anda mengelola dan memantau semua aset IT dalam organisasi. Gunakan menu di sidebar untuk mengnavigasi fitur-fitur yang tersedia.
        </p>
    </div>
</x-tailadmin-app-layout>
