<x-layoutAdmin>
    <x-title>
        Laporan Barang Terjual
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">

        {{-- form untuk tanggal input pilih bulan --}}
        {{-- <div class="bg-slate-200 p-5 my-2 w-1/2">
            <form action="">
                <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari barang..." />
                <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
            </form>
        </div> --}}

        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Nama Barang</th>
                    <th class="border border-slate-600">Kode Barang</th>
                    <th class="border border-slate-600">Terjual</th>
                    <th class="border border-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barangTerjual as $b)
                    <tr>
                        <td class="border border-slate-600">{{ $b->nama_varian_barang }}</td>
                        <td class="border border-slate-600 text-center">{{ $b->kode_barang }}</td>
                        <td class="border border-slate-600 text-center">{{ $b->total_terjual }}</td>
                        <td class="border border-slate-600 text-center">
                            <a
                                href="{{ route('LaporanPenjualanBarangById', ['barang' => $b->varian_barang_id]) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</x-layoutAdmin>
