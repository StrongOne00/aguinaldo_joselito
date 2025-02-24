<button
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => {
        localStorage.setItem('darkMode', val)
        val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')
    })"
    @click="darkMode = !darkMode"
    type="button"
    class="relative inline-flex flex-shrink-0 h-6 mr-5 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer bg-gray-200 dark:bg-gray-700 w-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    role="switch"
    aria-checked="false"
>
    <span class="sr-only">Toggle dark mode</span>
    <span
        aria-hidden="true"
        :class="{ 'translate-x-5': darkMode, 'translate-x-0': !darkMode }"
        class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow pointer-events-none ring-0"
    >
        <span
            :class="{ 'opacity-0 ease-out duration-100': darkMode, 'opacity-100 ease-in duration-200': !darkMode }"
            class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity"
        >
            <svg class="w-3 h-3 text-gray-400" fill="none" viewBox="0 0 12 12">
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h4M6 4v4"
                />
            </svg>
        </span>
        <span
            :class="{ 'opacity-100 ease-in duration-200': darkMode, 'opacity-0 ease-out duration-100': !darkMode }"
            class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity"
        >
            <svg class="w-3 h-3 text-indigo-600" fill="currentColor" viewBox="0 0 12 12">
                <path
                    d="M3.707 5.293a1 1 0 00-1.414 1.414l1.414-1.414zM5 8l-.707.707a1 1 0 001.414 0L5 8zm4.707-3.293a1 1 0 00-1.414-1.414l1.414 1.414zm-7.414 2l2 2 1.414-1.414-2-2-1.414 1.414zm3.414 2l4-4-1.414-1.414-4 4 1.414 1.414z"
                />
            </svg>
        </span>
    </span>
</button> 