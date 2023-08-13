<x-layoutAdmin>
    <x-title>
        Daftar Barang Yang Ditawarkan Ke Toko
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-between bg-red-">
            <a href="{{ route('createBarangSupplier') }}" class="border rounded-lg p-1 my-2 bg-green-500">Tambah
                Barang</a>
            <div>
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari barang..." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
        </div>

        <div>
            @if (count($barangSupplier) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Kode Barang</th>
                            <th class="border border-slate-600">Merek</th>
                            <th class="border border-slate-600">Harga Jual</th>
                            <th class="border border-slate-600">Deskripsi</th>
                            <th class="border border-slate-600" colspan="3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barangSupplier as $b)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->kode_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_jual) }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->deskripsi }}</td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showBarangSupplier', ['barangSupplier' => $b->id]) }}">Detail</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('editBarangSupplier', ['barangSupplier' => $b->id]) }}">Ubah</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <form method="POST"
                                        action="{{ route('deleteBarangSupplier', ['barangSupplier' => $b->id]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
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
