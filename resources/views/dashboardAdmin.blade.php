<x-layoutAdmin>
    <x-title>
        Dashboard
    </x-title>

    <div class="mx-5 mt-5 p-4 md:mx-10 grid grid-cols-5 gap-y-6">

        @if (auth()->user()->level != 3)
            <a href="{{ route('indexPenjualan') }}"
                class="bg-green-400 p-1 text-center w-[200px] h-[100px] flex rounded-lg">
                <div class="text-5xl font-bold m-auto opacity-75">
                    {{ $Penjualan }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Penjualan Aktif
                </div>
            </a>
            <a href="{{ route('indexBarangKurangDariMinimal') }}"
                class="bg-red-400 p-1 text-center w-[200px] h-[100px] flex rounded-lg">
                <div class="text-5xl font-bold m-auto opacity-75">
                    {{ $barangPersediaanMinimal }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Barang kurang dari stok minimal
                </div>
            </a>
            <a href="{{ route('indexPurchaseOrder') }}"
                class="bg-green-400 p-1 text-center w-[200px] h-[100px] flex rounded-lg">
                <div class="text-5xl font-bold m-auto opacity-75">
                    {{ $PO }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Purchase Order Aktif
                </div>
            </a>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $BarangMaster }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Barang Master
                </div>
            </div>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $VarianBarang }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Varian Barang
                </div>
            </div>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $Supplier }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Supplier
                </div>
            </div>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $Pelanggan }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Pelanggan
                </div>
            </div>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $Pengguna }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Pengguna
                </div>
            </div>
        @else
            <a href="{{ route('indexPurchaseOrderSupplier') }}"
                class="bg-green-400 p-1 text-center w-[200px] h-[100px] flex rounded-lg">
                <div class="text-5xl font-bold m-auto opacity-75">
                    {{ $POSupplier }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Purchase Order Aktif
                </div>
            </a>
            <div class="bg-primary p-1 text-center w-[200px] h-[100px] flex text-white rounded-lg">
                <div class="text-5xl font-bold m-auto mr-2 opacity-75">
                    {{ $barangSupplier }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Barang
                </div>
            </div>
            <a href="{{ route('indexBarangKurangDariMinimalUntukSupplier') }}"
                class="bg-red-400 p-1 text-center w-[200px] h-[100px] flex rounded-lg">
                <div class="text-5xl font-bold m-auto opacity-75">
                    {{ $barangToko }}
                </div>
                <div class="text-lg font-semibold m-auto">
                    Barang toko kurang dari stok minimal
                </div>
            </a>
        @endif

    </div>
</x-layoutAdmin>
