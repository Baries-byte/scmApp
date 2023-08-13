<x-layoutAdmin>
    <x-title>
        Daftar Barang Kurang Dari Persediaan Minimal
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div>
            @if (count($barang) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Kode Barang Toko</th>
                            <th class="border border-slate-600">Kode Produk</th>
                            <th class="border border-slate-600">Deskripsi</th>
                            <th class="border border-slate-600">Persediaan Minimal</th>
                            <th class="border border-slate-600">Persediaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $b)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $b->nama_varian_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->kode_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->kode_produk }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->deskripsi }}</td>
                                <td class="border border-slate-600 p-1 text-center">{{ $b->persediaan_min }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">{{ $b->jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center bg-red-300 ">Data barang tidak tersedia</p>
            @endif
        </div>
    </div>
</x-layoutAdmin>
