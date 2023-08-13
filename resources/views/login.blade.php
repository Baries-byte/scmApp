<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    @vite('resources/css/app.css')
    <title>SCM GB</title>
</head>

<body>
    <div class="fixed inset-0 flex justify-center items-center">
        <div class="bg-slate-200 h-fit w-[400px] text-center p-2 rounded-lg overflow-auto">
            <h3 class="text-2xl font-semibold my-4">Login Sistem <br> Toko Guna Bangunan</h3>
            <form method="POST" action="{{route('userAuth')}}" class="flex flex-col mx-4 gap-y-2 text-left">
                @csrf
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required class="p-1">
                @error('email')
                    <p class="text-red-500 text-xs -mt-1">{{ $message }}</p>
                @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password" required class="p-1">
                @error('password')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                    Login
                </button>
            </form>
            <div class="text-left mx-4">
                <a href="{{route('createPelangganUser')}}" class="text-sm text-primary">Registrasi Pengguna
                    Baru</a>
            </div>
        </div>
    </div>
</body>

</html>
