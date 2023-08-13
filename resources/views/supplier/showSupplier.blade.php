<x-layoutAdmin>
    <x-title>
        Detail Supplier {{ $supplier->nama_perusahaan }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
            <!-- data supplier -->
            <div>
                <h3 class="text-xl font-bold mb-5">Informasi Supplier</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/2" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Nama Perusahaan: </span>{{ $supplier->nama_perusahaan }}
                    </p>
                    <p><span class="font-bold">Kode Supplier: </span>{{ $supplier->kode_supplier }}</p>
                    <p>
                        <span class="font-bold">Alamat Perusahaan: </span>{{ $supplier->alamat }}
                    </p>
                    <p>
                        <span class="font-bold">Telepon Perusahaan: </span>{{ $supplier->telepon }}
                    </p>
                    <p>
                        <span class="font-bold">Email Perusahaan: </span>{{ $supplier->email }}
                    </p>
                    <p>
                        <span class="font-bold">Status Kerjasama: </span>
                        @switch($supplier->kerja_sama)
                            @case(0)
                                Belum kerjasama
                            @break

                            @case(1)
                                Sudah kerjasama
                            @break

                            @default
                        @endswitch
                    </p>
                    @if ($supplier->kerja_sama == 0)
                        <a href="{{ route('kerjasamaDenganSupplier', ['supplier' => $supplier->id]) }}"
                            class="bg-green-400 rounded-lg p-1 w-fit font-semibold">Kerjasama dengan
                            Supplier</a>
                    @endif
                </div>
                @if ($supplier->kode_supplier != true)
                    <a href="{{ route('generateKodeSupplier', ['supplier' => $supplier->id]) }}"
                        class="bg-green-400 p-1 rounded-lg">Buat Kode Supplier</a>
                @endif
            </div>

            <!-- data sales -->
            <div>
                <h3 class="text-xl font-bold mb-5">Informasi Sales</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/2" />
                <div class="grid grid-cols-1">
                    <p><span class="font-bold">Nama: </span>{{ $supplier->user->nama }}</p>

                    <p><span class="font-bold">No Telepon: </span>{{ $supplier->user->telepon }}</p>
                    <p>
                        <span class="font-bold">Email: </span>{{ $supplier->user->email }}
                    </p>
                    <p><span class="font-bold">Alamat: </span>{{ $supplier->user->alamat }}</p>
                </div>

            </div>
        </div>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <div>
            <h3 class="text-xl text-center font-bold mb-5">Penawaran Barang Supplier</h3>

            <div>
                @if (count($supplier->barangSupplier) != 0)
                    <table class="table table-auto border-collapse border border-slate-500 w-full">
                        <thead class="bg-slate-400">
                            <tr>
                                <th class="border border-slate-600">Nama Barang</th>
                                <th class="border border-slate-600">Kode Barang</th>
                                <th class="border border-slate-600">Merek</th>
                                <th class="border border-slate-600">Harga</th>
                                <th class="border border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($supplier->barangSupplier as $b)
                                <tr class="relative">
                                    <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->kode_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                                    <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_jual) }}</td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        <a
                                            href="{{ route('barangSupplier', ['supplier' => $supplier->id, 'barangSupplier' => $b->id]) }}">Detail</a>
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
    </div>
</x-layoutAdmin>
