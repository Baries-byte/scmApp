<x-layoutPembeli>
    <x-title>
        Pembayaran Transaksi Pemesanan
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">

        <div class="bg-slate-200 p-5 my-2 w-1/2 mx-auto">
            <p>
                Transaksi Pemesanan {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
            </p>
            <p>
                Kode Pemesanan: {{ $penjualan->kode_penjualan }}
            </p>
            <p>
                Metode Pengiriman:
                @switch($penjualan->metode_pengiriman)
                    @case(1)
                        Ambil Sendiri
                    @break

                    @case(2)
                        Dikirim Toko
                    @break

                    @default
                @endswitch
            </p>
            <p>
                Jumlah Item: {{ $penjualan->total_item }}
            </p>
            <p>
                Total Harga: Rp
                <span class="font-bold">
                    {{ format_uang($penjualan->total_harga) }}
                </span>
            </p>

            <p class="font-bold">
                Nomor Rekening Toko: 00000000
            </p>

            <form action="{{ route('uploadBuktiPembayaran', ['penjualan' => $penjualan->id]) }}" method="POST"
                enctype="multipart/form-data" class="flex flex-col gap-y-1">
                @csrf
                <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                <label for="">Upload Bukti Pembayaran</label>
                <input type="file" name="bukti_pembayaran" class="">
                @error('bukti_pembayaran')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <button class="bg-green-400 p-1 rounded-lg">Simpan</button>
            </form>
        </div>
    </div>
</x-layoutPembeli>
