<x-layoutPembeli>
    <div class="mx-5 mt-5 p-4 md:mx-10 flex">
        <div class="w-1/4 flex flex-col">
            <a href="{{ route('profileUserPelanggan') }}" class="font-semibold text-left my-2 hover:font-bold">Profile</a>
            <a href="{{ route('daftarTransaksiUserPelanggan') }}"
                class="font-semibold text-left my-2 hover:font-bold">Transaksi</a>
        </div>
        <div class="w-3/4 border-4 p-4">
            <div>
                <h3 class="text-center text-xl font-semibold mb-3">Daftar Transaksi</h3>
                @if (count($daftarPembelian) != 0)
                    <table class="table table-auto border-collapse border border-slate-500 w-full">
                        <thead class="bg-slate-400">
                            <tr>
                                <th class="border border-slate-600">Tanggal Pemesanan</th>
                                <th class="border border-slate-600">Kode Pemesanan</th>
                                <th class="border border-slate-600">Jumlah Item</th>
                                <th class="border border-slate-600">Jumlah Harga</th>
                                <th class="border border-slate-600">Status</th>
                                <th class="border border-slate-600" colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($daftarPembelian as $p)
                                <tr class="relative">
                                    <td class="border border-slate-600 p-1">
                                        {{ tanggal_indonesia($p->created_at->format('Y m d')) }}
                                    </td>
                                    <td class="border border-slate-600 p-1">
                                        {{ $p->kode_penjualan }}
                                    </td>
                                    <td class="border border-slate-600 p-1">{{ $p->total_item }}</td>
                                    <td class="border border-slate-600 p-1">Rp {{ format_uang($p->total_harga) }}
                                    </td>
                                    <td class="border border-slate-600 p-1"> {{ $p->status_transaksi }}
                                    </td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        <a
                                            href="{{ route('detailTransaksiUserPelanggan', ['penjualan' => $p->id]) }}">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="my-5">
                        {{ $daftarPembelian->links('vendor.pagination.tailwind') }}
                    </div>
                @else
                    <p class="text-center bg-red-300 ">Belum ada transaksi pembelian</p>
                @endif
            </div>
        </div>
    </div>
</x-layoutPembeli>
