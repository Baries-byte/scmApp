@if (session()->has('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-green-500 text-white text-center w-[400px] py-4 z-50 lg:w-1/2">
        <p>
            {{ session('success') }}
        </p>
    </div>
@endif

@if (session()->has('delete'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-red-500 text-white text-center w-[400px] py-4 z-50 lg:w-1/2">
        <p>
            {{ session('delete') }}
        </p>
    </div>
@endif

@if (session()->has('info'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
        class="fixed top-0 left-1/2 transform -translate-x-1/2 bg-primary  text-white text-center w-[400px] py-4 z-50 lg:w-1/2">
        <p>
            {{ session('info') }}
        </p>
    </div>
@endif
