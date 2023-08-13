<x-layoutAdmin>
    <x-title>
        Daftar Kategori
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-between">
            <div>
                <a href="{{ route('createKategori') }}" class="border rounded-lg p-1 my-2 bg-green-500"
                    id="btnOpenModalAddKategori">Tambah
                    Kategori</a>
            </div>
            <div>
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search"
                        placeholder="Cari kategori..." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
        </div>

        <div>
            <table class="table table-auto border-collapse border border-dlate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Kategori</th>
                        <th class="border border-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $k)
                        <tr>
                            <td class="border border-slate-600 p-1">{{ $k->kategori }}</td>
                            <td class="border border-slate-600 p-1 w-[200px] text-center">
                                <form method="POST" action="{{ route('deleteKategori', ['kategori' => $k->id]) }}">
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
            <div class="my-5">
                {{ $kategori->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-layoutAdmin>
