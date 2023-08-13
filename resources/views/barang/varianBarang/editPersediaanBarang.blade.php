<x-layoutAdmin>
    <x-title>
        Update Persediaan Barang {{ $varianBarang->nama_varian_barang }}
    </x-title>

    <div class="m-5">
        <form method="POST" action="{{ route('updatePersediaanBarang', ['persediaanBarang' => $persediaanBarang->id]) }}"
            class="flex flex-col gap-y-1">
            @csrf
            @method('PUT')
            <label for="persediaan" class="font-bold">Persediaan</label>
            <input type="number" name="persediaan" class="p-1 border border-black" placeholder="0"
                value="{{ $persediaanBarang->jumlah }}" />
            @error('persediaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="persediaan_min" class="font-bold">Persediaan Minimal</label>
            <input type="number" name="persediaan_min" class="p-1 border border-black" placeholder="0"
                value="{{ $persediaanBarang->persediaan_min }}" />
            @error('persediaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="persediaan_max" class="font-bold">Persediaan Maksimal</label>
            <input type="number" name="persediaan_max" class="p-1 border border-black" placeholder="0"
                value="{{ $persediaanBarang->persediaan_max }}" />
            @error('persediaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <label for="pembelian_optimal" class="font-bold">Pembelian Optimal</label>
            <input type="number" name="pembelian_optimal" class="p-1 border border-black" placeholder="0"
                value="{{ $persediaanBarang->pembelian_optimal }}" />
            @error('persediaan')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror

            <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                Ubah Persediaan Barang
            </button>
        </form>
    </div>
</x-layoutAdmin>
