<x-layoutAdmin>

    <x-title>
        Tambah Pengguna Baru
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('storeUser') }}" class="flex flex-col gap-y-1">
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
                placeholder="Konfirmasi Password" />
            @error('password_confirmation')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="telepon" class="font-bold">Telepon</label>
            <input type="text" name="telepon" class="p-1 border border-gray-300" placeholder="telepon"
                value="{{ old('telepon') }}" />
            @error('telepon')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="level" class="font-bold">Level Pengguna</label>
            <select name="level" id="level" class="p-1 border border-gray-300">
                <option value="">-pilih level-</option>
                <option value="2">Admin</option>
                <option value="3">Supplier</option>
            </select>
            @error('level')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Simpan
            </button>
        </form>
    </div>

</x-layoutAdmin>
