<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <title>SCM GB</title>
</head>

<body>
    <!-- Sidebar -->
    @include('partials._sidebarAdmin')
    <div class="md:ml-52 bg-white">
        <!-- navigation -->
        @include('partials._navbarAdmin')
        <!-- Main -->
        <main class="w-full">
            {{ $slot }}
        </main>
    </div>
    {{-- @include('script') --}}
    @include('partials._flash_message')
</body>

</html>
