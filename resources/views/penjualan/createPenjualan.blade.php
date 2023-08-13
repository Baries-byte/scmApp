<x-layoutAdmin>
    <x-title>
        Buat Transaksi Penjualan
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-between">
            <a href="{{ route('createPelanggan') }}" class="border rounded-lg p-1 my-2 bg-green-500">
                Tambah Pelanggan
            </a>
            <form action="">
                <input type="text" class="border rounded-lg p-1 my-2" name="search"
                    placeholder="Cari data pelanggan..." />
                <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
            </form>
        </div>

        <div>
            @if (count($pelanggan) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama </th>
                            <th class="border border-slate-600">Alamat</th>
                            <th class="border border-slate-600">Telepon</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $p)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">
                                    {{ $p->nama }}
                                </td>
                                <td class="border border-slate-600 p-1">
                                    {{ $p->alamat }}
                                </td>
                                <td class="border border-slate-600 p-1">
                                    {{ $p->telepon }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <form action="{{ route('storePenjualan') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="nama_pelanggan" value="{{ $p->nama }}">
                                        <input type="hidden" name="alamat_pelanggan" value="{{ $p->alamat }}">
                                        <input type="hidden" name="telepon_pelanggan" value="{{ $p->telepon }}">
                                        <button type="submit" class="hover:font-bold">Pilih</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $pelanggan->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <p class="text-center bg-red-300 ">Data pembeli tidak tersedia</p>
            @endif
        </div>
    </div>
</x-layoutAdmin>
