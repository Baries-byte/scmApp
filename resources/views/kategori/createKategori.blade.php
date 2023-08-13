<x-layoutAdmin>
    <x-title>
        Tambah Kategori Baru
    </x-title>
    <div class="m-5">
        <form action="{{ route('storeKategori') }}" method="post" class="flex flex-col gap-y-1 text-left">
            @csrf
            <label for="kategori" class="font-bold">Kategori</label>
            <input type="text" name="kategori" id="kategori" class="p-1 border border-slate-600" placeholder="Kategori"
                value="{{ old('kategori') }}" />
            @error('kategori')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <button class="bg-red-500 font-bold text-white rounded-full px-66 py-1 my-2 hover:bg-red-800">
                Tambah Kategori Baru
            </button>
        </form>
    </div>
</x-layoutAdmin>
