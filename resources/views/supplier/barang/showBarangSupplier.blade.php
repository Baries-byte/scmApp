<x-layoutAdmin>
    <x-title>
        Data Barang {{ $barangSupplier->nama_barang }}
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
                    <div>
                        <p>
                            <span class="font-bold">Nama:</span> {{ $barangSupplier->nama_barang }}
                        </p>
                        <p><span class="font-bold">Merek:</span> {{ $barangSupplier->merek }}</p>
                        <p>
                            <span class="font-bold">Harga Jual:</span>
                            Rp {{ format_uang($barangSupplier->harga_jual) }}
                        </p>
                        <p>
                            <span class="font-bold">Deskripsi:</span> {{ $barangSupplier->deskripsi }}
                        </p>
                    </div>
                </div>

                <!-- gambar -->
                <img class="lg:h-[400px] lg:w-[600px]" src="{{ asset('storage/' . $barangSupplier->foto) }}"
                    alt="" />
            </div>
        </div>
    </div>
</x-layoutAdmin>
