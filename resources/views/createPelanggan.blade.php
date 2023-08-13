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
            <h3 class="text-2xl font-semibold my-4">Registrasi Pengguna Baru</h3>
            <form method="POST" action="{{ route('storePelangganUser') }}" class="flex flex-col m-4 gap-y-2 text-left">
                @csrf
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Nama lengkap" class="p-1">
                @error('nama')
                    <p class="text-red-500 text-xs -mt-1">{{ $message }}</p>
                @enderror

                <label for="alamat">Alamat Lengkap</label>
                <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}"
                    placeholder="Alamat lengkap" class="p-1">
                @error('alamat')
                    <p class="text-red-500 text-xs -mt-1">{{ $message }}</p>
                @enderror

                <label for="telepon">Nomor Telepon</label>
                <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}" 
                    placeholder="Nomor Telepon" class="p-1">
                @error('telepon')
                    <p class="text-red-500 text-xs -mt-1">{{ $message }}</p>
                @enderror

                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Email" class="p-1">
                @error('email')
                    <p class="text-red-500 text-xs -mt-1">{{ $message }}</p>
                @enderror

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Password" class="p-1">
                @error('password')
                    <p class="text-red-500 text-xs">{{ $message }}</p>
                @enderror

                <label for="password_confirmation" class="font-bold">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="p-1 border border-gray-300"
                    placeholder="Konfirmasi Password" />
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror

                <button type="submit"
                    class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                    Registrasi
                </button>
            </form>
        </div>
    </div>
</body>

</html>
