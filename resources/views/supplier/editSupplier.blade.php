<x-layoutAdmin>

    <x-title>
        Edit Data Supplier {{ $supplier->nama_perusahaan }}
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('updateSupplier', ['supplier' => $supplier->id]) }}"
            class="flex flex-col gap-y-1">
            @csrf
            @method('PUT')
            <label for="nama_perusahaan" class="font-bold">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" class="p-1 border border-black" placeholder="Nama Perusahaan"
                value="{{ $supplier->nama_perusahaan }}" />
            @error('nama_perusahaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="alamat" class="font-bold">Alamat</label>
            <input type="text" name="alamat" class="p-1 border border-black" placeholder="Alamat"
                value="{{ $supplier->alamat }}" />
            @error('alamat')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="telepon" class="font-bold">Telepon Supplier</label>
            <input type="text" name="telepon" class="p-1 border border-black" placeholder="Telepon Supplier"
                value="{{ $supplier->telepon }}" />
            @error('telepon')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="email" class="font-bold">Email</label>
            <input type="text" name="email" class="p-1 border border-black" placeholder="email"
                value="{{ $supplier->email }}" />
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="user_id" class="font-bold">Sales:</label>
            <select name="user_id" id="user_id" class="p-1 border border-black">
                <option value="{{ $supplier->user->id }}">{{ $supplier->user->nama }}</option>
                @foreach ($user as $u)
                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                @endforeach
            </select>
            @error('user_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Ubah Data Supplier
            </button>
        </form>
    </div>

</x-layoutAdmin>
