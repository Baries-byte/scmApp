<x-layoutPembeli>
    <div class="mx-5 mt-5 p-4 mb-10 md:mx-10">
        <div class="w-full flex">
            {{-- gambar barang --}}
            <div class="w-full">
                <img class="lg:h-[400px] lg:w-[600px]" src="{{ asset('storage/' . $barang->foto) }}" alt="" />
            </div>

            <div class="w-full flex">
                {{-- informasi barang --}}
                <div class="w-1/2">
                    <h1 class="text-lg font-bold">
                        {{ $barang->nama_barang }}
                    </h1>
                    <h2 class="text-xl font-extrabold">
                        Rp {{ format_uang($barang->harga_jual) }}
                    </h2>
                    <br>
                    {{-- detail --}}
                    <div>
                        <p>
                            Kategori:
                            <a href="/?kategori_id={{ $barang->kategori_id }}"
                                class="text-primary">{{ $barang->kategori->kategori }}
                            </a>
                        </p>
                        <p>
                            Deskripsi:
                            <br>
                            {{ $barang->deskripsi }}
                        </p>
                    </div>
                </div>
                <div class="w-1/2 relative">
                    <div class="w-2/3 absolute right-0 rounded-lg border border-slate-600 py-1 px-3">
                        <p class="font-bold">Jumlah</p>
                        <form action="{{ route('addBarangKeranjangBelanja') }}" method="POST" class="flex flex-col">
                            @csrf
                            @if ($transaksiPembelianAktif == true)
                                <input type="hidden" name="penjualan_id" value="{{ $transaksiPembelianAktif->id }}">
                            @endif
                            <input type="hidden" name="barang_id" value="{{ $barang->id }}">
                            <input type="hidden" name="harga_jual" value="{{ $barang->harga_jual }}">
                            <div class="flex flex-row">
                                <input type="number" name="jumlah" class="w-[50px] mr-2 border text-center"
                                    value="1">
                                <p>Stok: <span class="font-bold">{{ $barang->persediaan->jumlah }}
                                        {{ $barang->satuan->satuan }}</span></p>
                            </div>
                            <button class="bg-green-400 p-1 rounded-lg my-2">
                                <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>Keranjang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layoutPembeli>
