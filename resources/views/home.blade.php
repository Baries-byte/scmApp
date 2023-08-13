<x-layoutPembeli>
    <h1 class="text-xl font-semibold text-center my-4">
        Daftar Ketersediaan Barang
    </h1>
    <div class="w-full mb-5">
        <form action="" class="w-full flex justify-center">
            <input type="text" class="border border-gray-500 rounded-lg p-1 my-2 w-1/2" name="search"
                placeholder="Cari barang..." />
            <button type="submit" class="bg-primary text-white rounded-lg w-20 m-2">
                <i class="fa fa-solid fa-search"></i>
            </button>
        </form>
    </div>
    <div class="flex w-full">
        <div class="px-1 w-full sm:w-5/6">
            <div class="flex flex-wrap gap-x-2 justify-center">
                @foreach ($barang as $b)
                    <div class="bg-slate-300 w-[250px] p-3 mb-4">
                        <div class="flex justify-center">
                            <img src="{{ asset('storage/' . $b->foto) }}" alt="gambar barang"
                                class="p-2 w-[240px] h-[200px]" />
                        </div>

                        <h3 class="mx-3 font-bold">
                            {{ $b->nama_varian_barang }}
                        </h3>

                        <p class="mx-3 mt-2 text-sm">
                            Persediaan <b>{{ $b->persediaan->jumlah }} {{ $b->satuan->satuan }}</b>
                        </p>
                        <div class="flex justify-center gap-x-4 my-4">
                            {{-- tambah barang ke keranjang --}}

                            <form action="{{ route('addBarangKeranjangBelanja') }}" method="POST">
                                @csrf
                                @if ($transaksiPembelianAktif == true)
                                    <input type="hidden" name="penjualan_id"
                                        value="{{ $transaksiPembelianAktif->id }}">
                                @endif
                                <input type="hidden" name="barang_id" value="{{ $b->id }}">
                                <input type="hidden" name="harga_jual" value="{{ $b->harga_jual }}">
                                <div class="flex">
                                    <input type="number" name="jumlah" value="1" class="w-[50px] text-center">
                                    <button type="submit"
                                        class="bg-green-400 py-1 px-3 ml-1 rounded-lg hover:font-semibold">
                                        <i class="fa fa-solid fa-cart-arrow-down bg-green-400 p-1 rounded-md"></i>
                                    </button>
                                </div>
                            </form>
                            <a href="{{ route('detailBarangHome', ['barang' => $b->id]) }}"
                                class="bg-primary py-1 px-3 rounded-lg hover:font-semibold">
                                Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="my-5">
                {{ $barang->links('vendor.pagination.tailwind') }}
            </div>
        </div>
        <div class="bg-slate-200 rounded-md w-1/6 mx-4 p-4 h-fit hidden sticky top-20 sm:block">
            <h3 class="font-semibold bg-white rounded-full p-1 text-center shadow-md">
                Kategori Barang
            </h3>
            <ul class="my-4 mx-5">
                <li class="list-disc hover:font-semibold">
                    <a href="/">Semua barang</a>
                </li>
                @foreach ($kategori as $k)
                    <li class="list-disc hover:font-semibold">
                        <a href="/?kategori_id={{ $k->id }}"> {{ $k->kategori }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</x-layoutPembeli>
