<x-layoutAdmin>
    <x-title>
        Daftar Supplier
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-between">
            <div>
                <a href="{{ route('createSupplier') }}" class="border rounded-lg p-1 my-2 bg-green-500">Tambah
                    Supplier</a>
            </div>
            <div>
                <input type="text" class="border rounded-lg p-1 my-2" placeholder="Cari supplier.." />
            </div>
        </div>
        <div>
            <table class="table table-auto border-collapse border border-slate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Nama Perusahaan</th>
                        <th class="border border-slate-600">Kode Supplier</th>
                        <th class="border border-slate-600">Alamat</th>
                        <th class="border border-slate-600">Sales</th>
                        <th class="border border-slate-600" colspan="3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $s)
                        <tr class="relative">
                            <td class="border border-slate-600 p-1">{{ $s->nama_perusahaan }}</td>
                            <td class="border border-slate-600 p-1">{{ $s->kode_supplier }}</td>
                            <td class="border border-slate-600 p-1">{{ $s->alamat }}</td>
                            <td class="border border-slate-600 p-1">{{ $s->user->nama }}</td>
                            <td class="border border-slate-600 p-1 text-center">
                                <a href="{{ route('showSupplier', ['supplier' => $s->id]) }}">Detail</a>
                            </td>
                            <td class="border border-slate-600 p-1 text-center">
                                <a href="{{ route('editSupplier', ['supplier' => $s->id]) }}">Ubah</a>
                            </td>
                            <td class="border border-slate-600 p-1 text-center">
                                <form method="POST" action="{{ route('deleteSupplier', ['supplier' => $s->id]) }}">
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
            <div class="my-5">
                {{ $supplier->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-layoutAdmin>
