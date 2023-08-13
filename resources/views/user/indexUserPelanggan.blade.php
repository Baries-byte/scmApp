<x-layoutAdmin>
    <x-title>
        Daftar Pelanggan
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        <div class="w-full flex justify-end">
            <form action="">
                <input type="text" class="border rounded-lg p-1 my-2" name="search"
                    placeholder="Cari data pelanggan..." />
                <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
            </form>
        </div>
        @if (count($pelanggan) != 0)
            <div>
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama</th>
                            <th class="border border-slate-600">Alamat</th>
                            <th class="border border-slate-600">Telepon</th>
                            <th class="border border-slate-600">Email</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan as $p)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $p->nama }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->alamat }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->telepon }}</td>
                                <td class="border border-slate-600 p-1">{{ $p->email }}</td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <form method="POST" action="/pengguna/{{ $p->id }}">
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
                    {{ $pelanggan->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @else
            <p class="text-center bg-red-300 ">
                Data pelanggan tidak ditemukan
            </p>
        @endif

    </div>
</x-layoutAdmin>
