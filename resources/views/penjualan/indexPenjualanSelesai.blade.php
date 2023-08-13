<x-layoutAdmin>
    <x-title>
        Daftar Transaksi Penjualan Selesai
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div id="transaksiSelesai">
            <div class="w-full flex">
                <a href="{{ route('createPenjualan') }}" class="rounded-lg p-1 my-2 bg-green-500">Buat Transaksi
                    Penjualan Baru
                </a>
                <a href="{{ route('indexPenjualan') }}" class="rounded-lg p-1 my-2 bg-primary mx-3 text-white">Penjualan
                    Aktif</a>
                <a href="{{ route('indexPenjualanSelesai') }}" class="rounded-lg p-1 my-2 bg-primary text-white">Penjualan
                    Selesai</a>
            </div>
            <div class="flex justify-end">
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search_penjualan"
                        placeholder="Cari transaksi.." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
            @if (count($penjualanSelesai) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Tanggal Penjualan</th>
                            <th class="border border-slate-600">Nama Pembeli</th>
                            <th class="border border-slate-600">Alamat</th>
                            <th class="border border-slate-600">Telepon</th>
                            <th class="border border-slate-600">Jumlah Item</th>
                            <th class="border border-slate-600">Jumlah Harga</th>
                            <th class="border border-slate-600">Status</th>
                            <th class="border border-slate-600">Kasir</th>
                            <th class="border border-slate-600" colspan="2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penjualanSelesai as $p)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">
                                    {{ tanggal_indonesia($p->created_at->format('Y m d')) }}
                                </td>
                                <td class="border border-slate-600 p-1">{{ $p->nama_pelanggan }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->alamat_pelanggan }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->telepon_pelanggan }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->total_item }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($p->total_harga) }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->status_transaksi }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->user->nama }}</td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showPenjualan', ['penjualan' => $p->id]) }}">Detail</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('cetakNotaPenjualan', ['penjualan' => $p->id]) }}"
                                        target="_blank">Print</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="my-5">
                    {{ $penjualanSelesai->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <p class="text-center bg-red-300 ">Data transaksi penjualan tidak tersedia</p>
            @endif
        </div>
    </div>

</x-layoutAdmin>
