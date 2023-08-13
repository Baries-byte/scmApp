<x-layoutAdmin>
    <x-title>
        Detail Barang Master {{ $barang->nama_barang }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div>
            <div>
                <h3 class="text-xl font-bold mb-5">Data Barang Master</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-full md:w-[250px]" />
            </div>
            <div class="flex flex-col-reverse justify-between lg:flex-row">
                <!-- detail barang -->
                <div class="flex justify-between flex-col-reverse mt-3 lg:mt-0 lg:flex-row">
                    <div class="">
                        <p>
                            <span class="font-bold">Nama:</span> {{ $barang->nama_barang }}
                        </p>
                        <p><span class="font-bold">Merek:</span> {{ $barang->merek }}</p>
                        <p>
                            <span class="font-bold">Supplier:</span>
                            {{ $barang->supplier->nama_perusahaan }}
                        </p>
                        <p><span class="font-bold">Kategori:</span> {{ $barang->kategori->kategori }}</p>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div>
            <div>
                <h3 class="text-xl font-bold mb-5">Daftar Varian Barang</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-full md:w-[250px]" />
            </div>
            <!-- search -->
            <div class="w-full flex justify-end bg-red-">
                <div>
                    <form action="">
                        <input type="text" class="border rounded-lg p-1 my-2" name="search"
                            placeholder="Cari barang..." />
                        <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                    </form>
                </div>
            </div>

            {{-- Varian Barang --}}
            <table class="table table-auto border-collapse border border-slate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Nama Barang</th>
                        <th class="border border-slate-600">Kode Barang</th>
                        <th class="border border-slate-600">Supplier</th>
                        <th class="border border-slate-600">Kategori</th>
                        <th class="border border-slate-600">Deskripsi</th>
                        <th class="border border-slate-600">Harga Beli</th>
                        <th class="border border-slate-600">Harga Jual</th>
                        <th class="border border-slate-600">Persediaan</th>
                        <th class="border border-slate-600" colspan="3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($varianBarang as $b)
                        <tr class="relative">
                            <td class="border border-slate-600 p-1">{{ $b->nama_varian_barang }}</td>
                            <td class="border border-slate-600 p-1">{{ $b->kode_barang }}</td>
                            <td class="border border-slate-600 p-1">{{ $barang->supplier->nama_perusahaan }}</td>
                            <td class="border border-slate-600 p-1">{{ $b->kategori->kategori }}</td>
                            <td class="border border-slate-600 p-1">{{ $b->deskripsi }}</td>
                            <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_beli) }}</td>
                            <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_jual) }}</td>
                            <td class="border border-slate-600 p-1 text-center">
                                {{ $b->persediaan->jumlah }}
                            </td>
                            <td class="border border-slate-600 p-1 text-center">
                                <a
                                    href="{{ route('showVarianBarangUntukSupplier', ['varianBarang' => $b->id]) }}">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layoutAdmin>
