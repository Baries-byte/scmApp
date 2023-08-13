<nav class="sticky top-0 bg-slate-200 w-full z-10 md:fixed md:w-52 mb:block md:left-0 md:top-0 md:bottom-0"
    id="sidebar">
    <!-- head sidebar collapse -->
    {{-- <div class="bg-transparent flex justify-between p-2 md:hidden">
        <button class="fa fa-bars text-2xl"></button>
        <div class="flex">
            <p class="text-2xl my-auto">Admin</p>
            <button
                class="bg-white rounded-full px-3 py-3 text-gray-900 mx-3 font-bold fa fa-user hover:bg-gray-400"></button>
        </div>
    </div> --}}

    <div class="items-center justify-between" id="sidebar-menu">
        <ul class="relative flex flex-col w-full">
            <li class="items-center">
                <a href="/dashboard" class="w-full p-2 py-4 font-bold flex justify-between focus:font-extrabold">
                    Dashboard
                </a>
            </li>
            @switch(auth()->user()->level)
                @case(1)
                    <span class="w-full p-2 font-semibold text-slate-500">
                        Master
                        <hr class="h-0.5 bg-slate-300" />
                    </span>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexBarangMaster') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bolder">
                            <i class="fa fa-solid fa-boxes"></i>
                            Barang Master
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexKategori') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-tags"></i>
                            Kategori
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexSatuan') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-tags"></i>
                            Satuan
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPurchaseOrder') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Purchase Order</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPengembalian') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Pengembalian Barang</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPembelian') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Pembelian</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPenjualan') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-sack-dollar"></i>
                            <span class="font-medium hover:font-bold">Penjualan</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexSupplier') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-people-carry"></i>
                            Supplier
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPelanggan') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pelanggan</span>
                        </a>
                    </li>
                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexLaporan') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Laporan</span>
                        </a>
                    </li>

                    <span class="w-full p-2 font-semibold text-slate-500">
                        Pengguna
                        <hr class="h-0.5 bg-slate-300" />
                    </span>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserPegawai') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pegawai</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserSales') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Supplier</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserPelanggan') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pelanggan</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('createUser') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Buat Akun</span>
                        </a>
                    </li>
                @break

                @case(2)
                    <span class="w-full p-2 font-semibold text-slate-500">
                        Menu Admin
                        <hr class="h-0.5 bg-slate-300" />
                    </span>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexBarangMaster') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bolder">
                            <i class="fa fa-solid fa-boxes"></i>
                            Barang Master
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexKategori') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-tags"></i>
                            Kategori
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexSatuan') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-tags"></i>
                            Satuan
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPurchaseOrder') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Purchase Order</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPengembalian') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Pengembalian Barang</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPembelian') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Pembelian</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPenjualan') }}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-sack-dollar"></i>
                            <span class="font-medium hover:font-bold">Penjualan</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexSupplier') }}"
                            class="my-2 mx-4 w-full font-medium hover:font-bold focus:font-bold">
                            <i class="fa fa-solid fa-people-carry"></i>
                            Supplier
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPelanggan') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pelanggan</span>
                        </a>
                    </li>

                    <span class="w-full p-2 font-semibold text-slate-500">
                        Pengguna
                        <hr class="h-0.5 bg-slate-300" />
                    </span>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserPegawai') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pegawai</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserSales') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Supplier</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexUserPelanggan') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-person"></span>
                            <span class="font-medium hover:font-bold">Pelanggan</span>
                        </a>
                    </li>
                @break

                @case(3)
                    <span class="w-full p-2 font-semibold text-slate-500">
                        Menu Supplier
                        <hr class="h-0.5 bg-slate-300" />
                    </span>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexBarangSupplier') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-boxes"></span>
                            <span class="font-medium hover:font-bold">Barang</span>
                        </a>
                    </li>
                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexPurchaseOrderSupplier') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-cart-plus"></span>
                            <span class="font-medium hover:font-bold">Purchase Order</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{ route('indexBarangMasterTokoUntukSupplier') }}" class="my-2 mx-4 w-full">
                            <span class="fa fa-solid fa-boxes"></span>
                            <span class="font-medium hover:font-bold">Barang Toko</span>
                        </a>
                    </li>

                    <li class="items-center mb-3 text-slate-700 md:my-2 hover:text-black">
                        <a href="{{route('indexPengembalianBarangSupplier')}}" class="my-2 mx-4 w-full">
                            <i class="fa fa-solid fa-cart-plus"></i>
                            <span class="font-medium hover:font-bold">Pengembalian Barang</span>
                        </a>
                    </li>
                @break

                @default
            @endswitch

        </ul>
    </div>
</nav>
