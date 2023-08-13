<x-layoutAdmin>

    <x-title>
        Tambah Supplier Baru
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('storeSupplier') }}" class="flex flex-col gap-y-1">
            @csrf
            <label for="nama_perusahaan" class="font-bold">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="p-1 border border-black" placeholder="Nama Perusahaan"
                value="{{ old('nama_perusahaan') }}" />
            @error('nama_perusahaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="alamat" class="font-bold">Alamat</label>
            <input type="text" name="alamat" class="p-1 border border-black" placeholder="Alamat" />
            @error('alamat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="telepon" class="font-bold">Telepon Supplier</label>
            <input type="text" name="telepon" class="p-1 border border-black" placeholder="Telepon Supplier" />
            @error('telepon')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="email" class="font-bold">Email</label>
            <input type="text" name="email" class="p-1 border border-black" placeholder="email" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="user_id" class="font-bold">Sales</label>
            <select name="user_id" id="user_id" class="p-1 border border-black">
                <option value="0">-pilih sales-</option>
                @foreach ($user as $u)
                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Tambah Supplier Baru
            </button>
        </form>
    </div>

</x-layoutAdmin>
