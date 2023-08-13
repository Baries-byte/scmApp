<x-layoutAdmin>
    <x-title>
        Tambah Satuan Baru
    </x-title>
    <div class="m-5">
        <form action="{{ route('storeSatuan') }}" method="post" class="flex flex-col gap-y-1 text-left">
            @csrf
            <label for="satuan" class="font-bold">Satuan</label>
            <input type="text" name="satuan" id="satuan" class="p-1 border border-slate-600" placeholder="Satuan"
                value="{{ old('satuan') }}" />
            @error('satuan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            <button class="bg-red-500 font-bold text-white rounded-full px-66 py-1 my-2 hover:bg-red-800">
                Tambah Satuan Baru
            </button>
        </form>
    </div>
</x-layoutAdmin>
