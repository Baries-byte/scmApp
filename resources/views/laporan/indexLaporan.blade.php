<x-layoutAdmin>
    <x-title>
        Laporan
    </x-title>

    <div class="mx-5 mt-5 p-4 md:mx-10 flex flex-cols">
        <a href="{{ route('indexLaporanPenjualan') }}"
            class="bg-primary text-white font-bold p-1 text-center w-[200px] h-[100px] flex mx-5">
            <span class="m-auto">
                Laporan Penjualan
            </span>
        </a>

        <a href="{{ route('indexLaporanPembelian') }}"
            class="bg-primary text-white font-bold p-1 text-center w-[200px] h-[100px] flex mx-5">
            <span class="m-auto">
                Laporan Pembelian
            </span>
        </a>

        <a href="{{ route('indexLaporanPurchaseOrder') }}"
            class="bg-primary text-white font-bold p-1 text-center w-[200px] h-[100px] flex mx-5">
            <span class="m-auto">
                Laporan Purchase Order
            </span>
        </a>

        <a href="{{ route('indexLaporanBarang') }}"
            class="bg-primary text-white font-bold p-1 text-center w-[200px] h-[100px] flex mx-5">
            <span class="m-auto">
                Laporan Barang
            </span>
        </a>
    </div>

</x-layoutAdmin>
