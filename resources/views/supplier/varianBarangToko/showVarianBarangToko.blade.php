<x-layoutAdmin>
    <x-title>
        Detail Barang {{ $varianBarang->nama_varian_barang }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div>
            <div>
                <h3 class="text-xl font-bold mb-5">Data Barang</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-full md:w-[250px]" />
            </div>
            <div class="flex flex-col-reverse justify-between lg:flex-row">
                <!-- detail barang -->
                <div class="flex justify-between flex-col-reverse mt-3 lg:mt-0 lg:flex-row">
                    <div class="">
                        <p>
                            <span class="font-bold">Nama:</span> {{ $varianBarang->nama_varian_barang }}
                        </p>
                        <p>
                            <span class="font-bold">Kode Barang:</span> {{ $varianBarang->kode_barang }}
                        </p>
                        <p><span class="font-bold">Merek:</span> {{ $varianBarang->barangMaster->merek }}</p>
                        <p>
                            <span class="font-bold">Supplier:</span>
                            {{ $varianBarang->barangMaster->supplier->nama_perusahaan }}
                        </p>
                        @if ($varianBarang->persediaan == true)
                            <p>
                                <span class="font-bold">Persediaan Max:</span>
                                {{ $varianBarang->persediaan->persediaan_max }}
                            </p>
                            <p>
                                <span class="font-bold">Persediaan Min:</span>
                                {{ $varianBarang->persediaan->persediaan_min }}
                            </p>
                            <p
                                class="{{ $varianBarang->persediaan->jumlah <= $varianBarang->persediaan->persediaan_min ? 'bg-red-400 rounded-lg' : ' ' }} {{ $varianBarang->persediaan->jumlah > $varianBarang->persediaan->persediaan_max ? 'bg-primary rounded-lg' : ' ' }}">
                                <span class="font-bold">Persediaan:</span>
                                {{ $varianBarang->persediaan->jumlah }} {{ $varianBarang->satuan->satuan }}
                            </p>
                            <p>
                                <span class="font-bold">Pembelian Optimal:</span>
                                {{ $varianBarang->persediaan->pembelian_optimal }}
                            </p>
                        @endif

                        <p>
                            <span class="font-bold">Kategori:</span>
                            {{ $varianBarang->kategori->kategori }}
                        </p>
                        <p>
                            <span class="font-bold">Satuan:</span>
                            {{ $varianBarang->satuan->satuan }}
                        </p>
                        <p>
                            <span class="font-bold">Harga Beli:</span>
                            Rp {{ format_uang($varianBarang->harga_beli) }}
                        </p>
                        <p>
                            <span class="font-bold">Harga Jual:</span>
                            Rp {{ format_uang($varianBarang->harga_jual) }}
                        </p>
                        <p>
                            <span class="font-bold">Deskripsi:</span> {{ $varianBarang->deskripsi }}
                        </p>
                    </div>
                </div>

                <!-- gambar -->
                <img class="lg:h-[400px] lg:w-[600px]" src="{{ asset('storage/' . $varianBarang->foto) }}"
                    alt="foto barang" />
            </div>
        </div>
</x-layoutAdmin>
