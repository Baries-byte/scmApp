<div class="bg-slate-300 w-[250px] p-3 mb-4">
    <div class="flex justify-center">
        <img src=""
            alt="gambar barang" class="p-2 w-[240px] h-[200px]" />
    </div>

    <h3 class="mx-3 font-bold">
        {{ $b->nama_barang }}
    </h3>

    <p class="mx-3 mt-2 text-sm">
        Persediaan <b>{{ $b->stok }}</b>
    </p>
    <div class="flex justify-center gap-x-4 my-4">
        {{-- tambah barang ke keranjang --}}
        @if (Auth::check())
            <form action="{{ route('addBarangKeranjangBelanja') }}" method="POST">
                @csrf
                @if ($adaTransaksiAktif == true)
                    <input type="hidden" name="penjualan_id"
                        value="{{ $transaksiPembelianAktif->id }}">
                @endif
                <input type="hidden" name="barang_id" value="{{ $b->id }}">
                <input type="hidden" name="harga_jual" value="{{ $b->harga_jual }}">
                <div class="flex">
                    <input type="number" name="jumlah" value="1" class="w-[50px]">
                    <button type="submit"
                        class="bg-green-400 py-1 px-3 rounded-lg hover:font-semibold">
                        Beli
                    </button>
                </div>
            </form>
        @endif
        <button class="bg-primary py-1 px-3 rounded-lg hover:font-semibold">
            Detail
        </button>
    </div>
</div>