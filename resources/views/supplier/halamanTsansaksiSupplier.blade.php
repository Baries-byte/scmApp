<x-layoutAdmin>
    <x-title>
        Detail Supplier {{ $supplier->nama_perusahaan }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
            <!-- data supplier -->
            <div>
                <h3 class="text-xl font-bold mb-5">Informasi Supplier</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/2" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Nama Perusahaan: </span>{{ $supplier->nama_perusahaan }}
                    </p>
                    <p><span class="font-bold">Alamat Perusahaan: </span>{{ $supplier->alamat }}</p>
                </div>
            </div>

            <!-- data sales -->
            <div>
                <h3 class="text-xl font-bold mb-5">Informasi Sales</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/2" />
                <div class="grid grid-cols-1">
                    <p><span class="font-bold">Nama: </span>{{ $supplier->user->nama }}</p>
                    <p><span class="font-bold">No Telepon: </span>{{ $supplier->user->telepon }}</p>
                    <p>
                        <span class="font-bold">Email: </span>{{ $supplier->user->email }}
                    </p>
                    <p><span class="font-bold">Alamat: </span>{{ $supplier->user->alamat }}</p>
                </div>
            </div>
        </div>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <!-- daftar barang yang disupply -->
        <div>
            <h3 class="text-xl font-bold">Barang dari Supplier</h3>
            <div class="w-full overflow-x-auto">
                <table class="table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Merek</th>
                            <th class="border border-slate-600">Persediaan</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ $supplier->barang }} --}}
                        @foreach ($supplier->barang as $b)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->stok }}</td>
                                <td class="border border-slate-600 p-1"><a
                                        href="/barang/{{ $b->id }}">Detail</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <!-- daftar transaksi -->
        <div>
            <h3 class="text-xl font-bold">Daftar Transaksi Pembelian</h3>
            <div class="w-full overflow-x-auto">
                <table class="table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600">Tanggal Pembelian</th>
                            <th class="border border-slate-600">Status Pembayaran</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="border border-slate-600 p-1">3 Maret 20282</td>
                            <td class="border border-slate-600 p-1">Lunas</td>
                            <td class="border border-slate-600 p-1">
                                <a href="detail_pengembalian_barang.html">Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layoutAdmin>
