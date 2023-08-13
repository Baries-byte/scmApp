<x-layoutAdmin>
    <x-title>
        Membuat Purchase Order
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <h3 class="font-bold">Pilih Supplier</h3>

        <form action="" class="flex justify-end">
            <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari supplier..." />
            <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20 my-2">Cari</button>
        </form>
        <div>
            <table class="table table-auto border-collapse border border-slate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Nama Perusahaan</th>
                        <th class="border border-slate-600">Alamat</th>
                        <th class="border border-slate-600">Sales</th>
                        <th class="border border-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier as $s)
                        <tr class="relative">
                            <td class="border border-slate-600 p-1">{{ $s->nama_perusahaan }}</td>
                            <td class="border border-slate-600 p-1">{{ $s->alamat }}</td>
                            <td class="border border-slate-600 p-1">{{ $s->user->nama }}</td>
                            <td class="border border-slate-600 p-1 text-center">
                                <form action="{{ route('storePurchaseOrder') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="supplier_id" value="{{ $s->id }}">
                                    <button type="submit" class="hover:font-bold">Pilih</button>
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
