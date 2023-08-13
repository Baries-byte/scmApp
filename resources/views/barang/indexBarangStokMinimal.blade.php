<x-layoutAdmin>
    <x-title>
        Daftar Barang Kurang Dari Persediaan Minimal
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div>
            @if (count($varianBarang) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Kode Barang</th>
                            <th class="border border-slate-600">Kode Produk</th>
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
                                <td class="border border-slate-600 p-1">{{ $b->kode_produk }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->barangMaster->supplier->nama_perusahaan }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->kategori->kategori }}</td>
                                <td class="border border-slate-600 p-1">{{ $b->deskripsi }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_beli) }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_jual) }}</td>
                                <td class="border border-slate-600 p-1 text-center">
                                    {{ $b->persediaan->jumlah }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showVarianBarang', ['varianBarang' => $b->id]) }}">Detail</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('editVarianBarang', ['varianBarang' => $b->id]) }}">Ubah</a>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <form method="POST"
                                        action="{{ route('deleteVarianBarang', ['varianBarang' => $b->id]) }}">
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
                {{-- <div class="mt-5">
                    {{ $barang->links('vendor.pagination.tailwind') }}
                </div> --}}
            @else
                <p class="text-center bg-red-300 ">Data barang tidak tersedia</p>
            @endif
        </div>
    </div>
</x-layoutAdmin>
