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
        <div class="bg-gray-200 h-fit w-[400px] text-center p-2 rounded-lg overflow-auto">
            <h3 class="text-2xl font-semibold my-4">Daftar Pengguna Baru </h3>
            <form method="POST" action="{{ route('storeUser') }}" class="flex flex-col gap-y-1 text-start">
                @csrf
                <label for="nama" class="font-bold">Nama Pengguna</label>
                <input type="text" name="nama" class="p-1 border border-gray-300" placeholder="Nama Pengguna"
                    value="{{ old('nama') }}" />
                @error('nama')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="email" class="font-bold">Email</label>
                <input type="email" name="email" class="p-1 border border-gray-300" placeholder="email"
                    value="{{ old('email') }}" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="alamat" class="font-bold">Alamat</label>
                <input type="text" name="alamat" class="p-1 border border-gray-300" placeholder="alamat"
                    value="{{ old('alamat') }}" />
                @error('alamat')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="password" class="font-bold">Password</label>
                <input type="password" name="password" class="p-1 border border-gray-300" placeholder="password"
                    value="{{ old('password') }}" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="password_confirmation" class="font-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="p-1 border border-gray-300"
                    placeholder="konfirmasi passsword" value="{{ old('password_confirmation') }}" />
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <label for="telepon" class="font-bold">Telepon</label>
                <input type="text" name="telepon" class="p-1 border border-gray-300" placeholder="telepon"
                    value="{{ old('telepon') }}" />
                @error('telepon')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <input type="hidden" name="level" class="p-1 border border-gray-300" placeholder="telepon"
                    value="0" />

                <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                    Daftar
                </button>
            </form>
        </div>
    </div>
</body>

</html>
