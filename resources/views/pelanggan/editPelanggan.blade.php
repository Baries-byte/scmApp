<x-layoutAdmin>
    <x-title>
        Ubah data pelanggan
    </x-title>

    <div class="m-5">
        <form action="{{route('updatePelanggan', ['pelanggan' => $pelanggan->id])}}" method="POST" class="flex flex-col gap-y-1 text-left">
            @csrf
            @method('PUT')
            <label for="nama_pelanggan" class="font-bold">Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="p-1 border border-slate-600" placeholder="Nama Pelanggan"
                value="{{ $pelanggan->nama }}">
            @error('nama_pelanggan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="alamat_pelanggan" class="font-bold">Alamat Pelanggan</label>
            <input type="text" name="alamat_pelanggan" class="p-1 border border-slate-600"
                placeholder="Alamat lengkap pelanggan" value="{{ $pelanggan->alamat }}">
            @error('alamat_pelanggan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="telpon_pelanggan" class="font-bold">Telpon Pelanggan</label>
            <input type="text" name="telepon_pelanggan" class="p-1 border border-slate-600"
                placeholder="Telepon pelanggan" value="{{ $pelanggan->telepon }}">
            @error('telpon_pelanggan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-66 py-1 my-2 hover:bg-red-800">
                Ubah data pelanggan
            </button>
        </form>
    </div>
</x-layoutAdmin>
