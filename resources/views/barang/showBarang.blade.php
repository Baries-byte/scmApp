<x-layoutAdmin>
    <x-title>
        Detail Barang {{ $barang->nama_barang }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div>
            <div>
                <h3 class="text-xl font-bold mb-5">Data Barang</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-full md:w-[250px]" />
            </div>
            <div class="flex flex-col-reverse justify-between lg:flex-row">
                <!-- detail barang -->
                <div class="flex justify-between flex-col-reverse mt-3 lg:mt-0 lg:flex-row">
                    <div class="">
                        <p>
                            <span class="font-bold">Nama:</span> {{ $barang->nama_barang }}
                        </p>
                        <p>
                            <span class="font-bold">Kode Barang:</span> {{ $barang->kode_barang }}
                        </p>
                        <p><span class="font-bold">Merek:</span> {{ $barang->merek }}</p>
                        <p>
                            <span class="font-bold">Supplier:</span>
                            {{ $barang->supplier->nama_perusahaan }}
                        </p>
                        @if ($barang->persediaan == true)
                            <p>
                                <span class="font-bold">Persediaan Max:</span>
                                {{ $barang->persediaan->persediaan_max }}
                            </p>
                            <p>
                                <span class="font-bold">Persediaan Min:</span>
                                {{ $barang->persediaan->persediaan_min }}
                            </p>
                            <p
                                class="{{ $barang->persediaan->jumlah <= $barang->persediaan->persediaan_min ? 'bg-red-400 rounded-lg' : ' ' }} {{ $barang->persediaan->jumlah > $barang->persediaan->persediaan_max ? 'bg-primary rounded-lg' : ' ' }}">
                                <span class="font-bold">Persediaan:</span>
                                {{ $barang->persediaan->jumlah }} {{ $barang->satuan }}
                            </p>
                            <p>
                                <span class="font-bold">Pembelian Optimal:</span>
                                {{ $barang->persediaan->pembelian_optimal }}
                            </p>
                        @endif

                        <p>
                            <span class="font-bold">Kategori:</span>
                            {{ $barang->kategori->kategori }}
                        </p>
                        <p>
                            <span class="font-bold">Satuan:</span>
                            {{ $barang->satuan }}
                        </p>
                        <p>
                            <span class="font-bold">Harga Beli:</span>
                            Rp {{ format_uang($barang->harga_beli) }}
                        </p>
                        <p>
                            <span class="font-bold">Harga Jual:</span>
                            Rp {{ format_uang($barang->harga_jual) }}
                        </p>
                        <p>
                            <span class="font-bold">Deskripsi:</span> {{ $barang->deskripsi }}
                        </p>

                        <div class="flex flex-col gap-y-2">
                            @if ($barang->kode_barang != true)
                                <a href="{{ route('generateKodeBarang', ['barang' => $barang->id]) }}"
                                    class="bg-green-400 p-1 rounded-lg text-center">Buat kode barang</a>
                            @endif

                            <a href="{{ route('editPersediaanBarang', ['barang' => $barang->id]) }}"
                                class="bg-green-400 p-1 rounded-lg text-center">Update
                                Persediaan Barang
                            </a>

                            <a href="{{ route('hitungSMABarang', ['barang' => $barang->id]) }}"
                                class="bg-primary p-1 rounded-lg text-white text-center">Perkiraan Penjualan
                                Barang
                            </a>

                            <button class="bg-primary p-1 rounded-lg text-white text-center" id="btnEOQ">
                                Hitung Pembelian Optimal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- gambar -->
                <img class="lg:h-[400px] lg:w-[600px]" src="{{ asset('storage/' . $barang->foto) }}"
                    alt="foto barang" />
            </div>
        </div>


        <div>
            @isset($dataPenjualanBarang)
                <hr class="my-5 border-t-2 border-t-slate-500" />
                <x-title>
                    Perhitungan SMA
                </x-title>

                <h1 class="font-bold ">Data Penjualan Barang</h1>
                <table class="table table-auto border-collapse border border-slate-500 w-1/2">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Bulan</th>
                            <th class="border border-slate-600">Tahun</th>
                            <th class="border border-slate-600">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPenjualanBarang as $item)
                            <tr>
                                <td class="border border-slate-600 text-center">{{ $item->bulan }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->tahun }}</td>
                                <td class="border border-slate-600 text-center">{{ $item->jumlah }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="border border-slate-600 text-center" colspan="2">Total Penjualan
                                {{ count($dataPenjualanBarang) }} bulan terakhir</th>
                            <td class="font-bold text-center">{{ $totalSetahun }}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
            @endisset

            @isset($dataPrediksiSMASetahun, $totalPrediksiSetahun)
                <h1 class="font-bold">Data Prediksi Barang Selama Setahun</h1>
                {{-- {{ $dataPrediksiSMASetahun }} --}}
                <table class="table table-auto border-collapse border border-slate-500 w-[200px]">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Prediksi Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dataPrediksiSMASetahun as $prediksi)
                            <tr>
                                <td class="border border-slate-600 text-center">{{ $prediksi }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="font-bold text-center">{{ $totalPrediksiSetahun }}</td>
                        </tr>
                    </tbody>
                </table>
            @endisset
        </div>


        @isset($permintaan, $biayaPembelian, $biayaPenyimpanan, $EOQ)
            <hr class="my-5 border-t-2 border-t-slate-500" />
            <div>
                <p>
                    Permintaan Setahun:
                    <span class="font-bold">{{ $permintaan }}</span>
                </p>
                <p>
                    Biaya Pembelian Setahun:
                    <span class="font-bold">Rp {{ format_uang($biayaPembelian) }}</span>
                </p>
                <p>
                    Biaya Penyimpanan Setahun:
                    <span class="font-bold">Rp {{ format_uang($biayaPenyimpanan) }}</span>
                </p>
                <p>
                    Jumlah Optimal Setiap Pembelian:
                    <span class="font-bold">{{ $EOQ }}</span>
                </p>
                <div class="my-3">
                    <form action="{{ route('updatePembelianOptimal', ['barang' => $barang->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="nilaiEOQ" value="{{ $EOQ }}">
                        <button class="bg-green-400 p-1 rounded-lg">Perbarui Jumlah Pembelian Optimal</button>
                    </form>
                </div>
            </div>
        @endisset
        {{-- Form Hitung EOQ --}}
        <div class="bg-black bg-opacity-50 fixed inset-0 z-10 flex hidden justify-center items-center" id="modalEOQ">
            <div class="bg-gray-200 h-fit w-[500px] text-center py-2 px-5 rounded-lg overflow-auto">
                <div class="w-full px-3 text-right">
                    <button id="btnCloseModalEOQ">
                        <i class="fa fa-close text-black"></i>
                    </button>
                </div>
                <h3 class="font-bold text-2xl my-3">Masukkan Data Untuk Hitung Pembelian Optimal</h3>
                <form action="{{ route('hitungEOQBarang', ['barang' => $barang->id]) }}"
                    class="flex flex-col gap-y-1 text-left" method="GET">
                    @csrf
                    <label for="permintaan" class="font-bold">Permintaan Barang Setahun</label>
                    <input type="number" id="permintaan" name="permintaan">
                    <label for="biaya_pembelian" class="font-bold">Biaya Pembelian Setiap Pembelian</label>
                    <input type="number" id="biaya_pembelian" name="biaya_pembelian">
                    <label for="biaya_penyimpanan" class="font-bold">Biaya Penyimpanan Setiap Unit Setahun</label>
                    <input type="number" id="biaya_penyimpanan" name="biaya_penyimpanan">
                    <button class="bg-red-500 font-bold text-white rounded-full px-6 py-1 my-2 hover:bg-red-800">
                        Hitung
                    </button>
                </form>
            </div>
        </div>
        <script>
            $(function() {
                $('#btnEOQ').click(function() {
                    $('#modalEOQ').removeClass("hidden");
                })
                $('#btnCloseModalEOQ').click(function() {
                    $('#modalEOQ').addClass("hidden");
                })
            })
        </script>
</x-layoutAdmin>
