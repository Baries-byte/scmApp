<x-layoutAdmin>
    <x-title>
        Daftar Barang Master
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-between bg-red-">
            <a href="{{ route('createBarangMaster') }}" class="border rounded-lg p-1 my-2 bg-green-500">Tambah
                Barang Master</a>
            <div>
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari barang..." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
        </div>

        {{-- <div>
            @if (count($barang) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Supplier</th>
                            <th class="border border-slate-600">Merek</th>
                            <th class="border border-slate-600">Kategori</th>
                            <th class="border border-slate-600" colspan="3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $b)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->supplier->nama_perusahaan }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->kategori->kategori }}</td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showBarang', ['barang' => $b->id]) }}">Detail</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('editBarang', ['barang' => $b->id]) }}">Ubah</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <form method="POST" action="">
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

                <!-- Pagination -->
                <div class="mt-5">
                    {{ $barang->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <p class="text-center bg-red-300 ">Data barang tidak tersedia</p>
            @endif
        </div> --}}

        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Nama Barang</th>
                    <th class="border border-slate-600">Supplier</th>
                    <th class="border border-slate-600">Merek</th>
                    <th class="border border-slate-600">Kategori</th>
                    <th class="border border-slate-600" colspan="3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($barang as $b)
                    <tr class="relative">
                        <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                        <td class="border border-slate-600 p-1">{{ $b->supplier->nama_perusahaan }}</td>
                        <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                        <td class="border border-slate-600 p-1">{{ $b->kategori->kategori }}</td>
                        <td class="border border-slate-600 p-1 text-center">
                            <a href="{{ route('showBarangMaster', ['barang' => $b->id]) }}">Detail</a>
                        </td>
                        <td class="border border-slate-600 p-1 text-center">
                            <a href="{{ route('editBarangMaster', ['barang' => $b->id]) }}">Ubah</a>
                        </td>
                        <td class="border border-slate-600 p-1 text-center">
                            <form method="POST" action="{{route('deleteBarangMaster' , ['barang' => $b->id])}}">
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
    </div>
</x-layoutAdmin>
