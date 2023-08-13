<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Barang;
use App\Models\Penjualan;
use App\Models\VarianBarang;
use Illuminate\Http\Request;
use App\Models\DetailPenjualan;

class UserPelangganController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //profile user pembeli
    public function profileUserPelanggan()
    {
        // dd(count($daftarPembelian));
        return view('userPelanggan.profileUserPelanggan');
    }

    public function profileEditPelanggan()
    {
        return view('userPelanggan.editProfilePelanggan');
    }

    public function editPasswordUserPelanggan()
    {
        return view('userPelanggan.editPasswordPelanggan');
    }

    public function updateProfileUserPelanggan(Request $request, User $user){

        // dd($user);
        $formFields = $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'email' => 'required'
        ], [
            'nama.required' => 'Kolom nama harus diisi.',
            'alamat.required' => 'Kolom alamat harus diisi.',
            'telepon.required' => 'Kolom telepon harus diisi.',
            'email.required' => 'Kolom email harus diisi.'
        ]);

        $user->update($formFields);

        return back()->with('success', 'Informasi profile berhasil diperbarui');
    }

    public function daftarTransaksiUserPelanggan()
    {
        $daftarPembelian = Penjualan::where('user_id', '=', auth()->user()->id)->where('status_transaksi', '!=', 'Aktif')->latest()->paginate(20);
        return view('userPelanggan.daftarTransaksiPelanggan', [
            'daftarPembelian' => $daftarPembelian
        ]);
    }

    // show detail transaksi pembelian akses dari profile
    public function detailTransaksiUserPelanggan(Penjualan $penjualan){
        $detailPembelian = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)
        ->get();
        
        // dd($penjualan);
        return view('userPelanggan.detailTransaksiUserPelanggan', [
            'pembelian' => $penjualan,
            'detailPembelian' => $detailPembelian
        ]);
    }

    // halaman keranjang belanja sudah ada data penjualan
    public function keranjangBelanja(){
        $transaksiPembelianAktif = Penjualan::where('user_id', '=', auth()->user()->id)
        ->where('status_transaksi', '=', 'Aktif')
        ->first();

        $barang = VarianBarang::filter(request(['search']))->paginate(5);

        $adaTransaksiAktif = false;
        
            // bikin cek transaksi dlu ada atau nggak klo ada kerjain yang atas klo nggak cuma return view aja
            // bikin pake variable $adaTransaksi = true.
            // $adaTransaksi = false kalau ga ada transaksi aktif

        // check ada transaksi aktif atau tidak
        if($transaksiPembelianAktif == true)
        {
            // jika ada transaksi aktif (ada barang atau tidak ada barang)
            $adaTransaksiAktif = true;
            // diambil dari penjualan has many detail penjualan
            $detailPembelian = $transaksiPembelianAktif->detailPenjualan;

            return view('userPelanggan.keranjangBelanja', [
                'transaksiPembelianAktif' => $transaksiPembelianAktif,
                'barang' => $barang ,
                'detailPembelian' => $detailPembelian,
                'adaTransaksiAktif' => $adaTransaksiAktif
            ]);
        } 
        else 
        {
            // jika tidak ada transaksi aktif
            return view('userPelanggan.keranjangBelanja', [
                'adaTransaksiAktif' => $adaTransaksiAktif,
                'barang' => $barang
            ]);
        }
    }

    // add barang ke keranjang
    // cek dlu ada transaksi aktif atau nggak
    // kalau ada transaksi aktif cek sudah ada barang di transaksi aktif atau belum
    // kalau ada barang di transaksi aktif update jumlah barang
    // kalau ga ada barang add barang
    // kalau ga ada transaksi aktif bikin transaksi aktif dan add barang ke keranjang
    public function addBarangKeranjangBelanja(Request $request)
    {
        $transaksiPembelianAktif = Penjualan::where('user_id', '=', auth()->user()->id)
        ->where('status_transaksi', '=', 'Aktif')
        ->first();
        $barang = VarianBarang::where('id', '=', $request->barang_id)->first();
        $penjualan = Penjualan::where('id', '=', $request->penjualan_id)->first();
        // dd($penjualan);

        if($transaksiPembelianAktif == true){
            $adaBarang = DetailPenjualan::where('penjualan_id', '=', $request->penjualan_id)
            ->where('varian_barang_id', '=', $request->barang_id)
            ->first();

            if($adaBarang == true){
                if(($adaBarang->jumlah_item + $request->jumlah) <= $barang->persediaan->jumlah){
                    $adaBarang->jumlah_item = $adaBarang->jumlah_item + $request->jumlah;
                    $adaBarang->sub_total = $adaBarang->jumlah_item * $request->harga_jual;
                    $adaBarang->save();
    
                    $transaksiPembelianAktif->total_harga = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianAktif->id)->sum('sub_total');
                    $transaksiPembelianAktif->total_item = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianAktif->id)->sum('jumlah_item');
                    $transaksiPembelianAktif->save();
    
                    return back()->with('success', 'Jumlah barang berhasil ditambah');
                }
                return back()->with('delete', 'persediaan barang tidak cukup');
            }

            if ($request->jumlah > 0) {
    
                if ($request->jumlah <= $barang->persediaan->jumlah) {
                    
                    // dd($request->penjualan_id);
                    // insert barang ke detail penjualan
                    $detailPenjualan = new DetailPenjualan();
                    $detailPenjualan->penjualan_id = $request->penjualan_id;
                    $detailPenjualan->varian_barang_id = $request->barang_id;
                    $detailPenjualan->jumlah_item = $request->jumlah;
                    $detailPenjualan->sub_total = $request->harga_jual * $request->jumlah;
                    $detailPenjualan->save();
    
                    // update sub_total dan jumlah_barang ke penjualan
                    $transaksiPembelianAktif->total_harga = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianAktif->id)->sum('sub_total');
                    $transaksiPembelianAktif->total_item = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianAktif->id)->sum('jumlah_item');
                    $transaksiPembelianAktif->save();
    
                    return back()->with('success', 'Barang berhasil ditambah ke keranjang');
                }
                return back()->with('delete', 'Persediaan barang tidak cukup.');
            }
            return back()->with('delete', 'Jumlah barang minimal 1.');
        }

        $tanggalHariIni = now()->format('Y-m-d');
        $nomorUrut = Penjualan::whereDate('created_at', $tanggalHariIni)->count();

        $transaksiPembelianBaru = new Penjualan();
        $transaksiPembelianBaru->user_id = auth()->user()->id;
        $transaksiPembelianBaru->nama_pelanggan = auth()->user()->nama;
        $transaksiPembelianBaru->alamat_pelanggan = auth()->user()->alamat;
        $transaksiPembelianBaru->telepon_pelanggan = auth()->user()->telepon;
        $transaksiPembelianBaru->total_item = 0;
        $transaksiPembelianBaru->total_harga = 0;
        $transaksiPembelianBaru->diskon = 0;
        // metode pembayaran transfer
        $transaksiPembelianBaru->metode_pembayaran = 2;
        $transaksiPembelianBaru->save();

        $transaksiPembelianBaru->kode_penjualan = kodePenjualan(auth()->user()->level, auth()->user()->id, $nomorUrut);
        $transaksiPembelianBaru->save();

        if ($request->jumlah > 0) {
    
            if ($request->jumlah <= $barang->persediaan->jumlah) {

                // insert barang ke table detail penjualan
                $detailPenjualan = new DetailPenjualan();
                $detailPenjualan->penjualan_id = $transaksiPembelianBaru->id;
                $detailPenjualan->varian_barang_id = $request->barang_id;
                $detailPenjualan->jumlah_item = $request->jumlah;
                $detailPenjualan->sub_total = $request->harga_jual * $request->jumlah;
                $detailPenjualan->save();

                // update sub_total dan jumlah_barang ke penjualan
                $transaksiPembelianBaru->total_harga = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianBaru->id)->sum('sub_total');
                $transaksiPembelianBaru->total_item = DetailPenjualan::where('penjualan_id', '=', $transaksiPembelianBaru->id)->sum('jumlah_item');
                $transaksiPembelianBaru->save();

                return back()->with('success', 'Barang berhasil ditambah ke keranjang');
            }
            return back()->with('delete', 'Persediaan barang tidak cukup.');
        }
    }

    public function updateJumlahBarangKeranjangBelanja(Request $request){
        // dd($request);
        $detailPenjualan = DetailPenjualan::find($request->id);
        $penjualan = Penjualan::where('id', '=', $request->penjualan_id)->first();
        $barang = VarianBarang::where('id', '=', $request->barang_id)->first();

        if ($request->jumlah > 0) {

            if ($request->jumlah <= $barang->persediaan->jumlah) {
                // update jumlah barang
                $detailPenjualan->jumlah_item = $request->jumlah;
                $detailPenjualan->sub_total = ($request->jumlah * $request->harga_jual);
                $detailPenjualan->save();

                // update sub_total dan jumlah_item ke penjualan
                $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
                $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
                $penjualan->save();

                return back()->with('success', 'Jumlah barang berhasil diperbarui.');
            }
            return back()->with('delete', 'Persediaan barang tidak cukup.');
        }
        return back()->with('delete', 'Jumlah barang tidak boleh kurang dari 1.');
    }

    public function deleteBarangKeranjangBelanja(DetailPenjualan $detailPenjualan){
        // variable penjualan
        $penjualan = Penjualan::where('id', '=', $detailPenjualan->penjualan_id)->first();

        //hapus barang dari database detail_penjualan 
        $detailPenjualan->delete();

        // update sub_total dan jumlah_barang ke penjualan
        $penjualan->total_harga = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('sub_total');
        $penjualan->total_item = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->sum('jumlah_item');
        $penjualan->save();

        return back()->with('delete', 'Barang berhasil dihapus dari pesanan.');
    }

    public function checkOut(Penjualan $penjualan)
    {
        // ubah status transaksi penjualan menjadi checkout
        $penjualan->status_transaksi = 'Check Out';
        $penjualan->save();
        $detailPenjualan = DetailPenjualan::where('penjualan_id', '=', $penjualan->id)->get();

        return view('userPelanggan.checkOutPelanggan', ['penjualan' => $penjualan, 'detailPenjualan' => $detailPenjualan]);
    }

    public function updateMetodePengiriman(Request $request, Penjualan $penjualan)
    {
        // dd($request);
        $penjualan->metode_pengiriman = $request->metode_pengiriman;
        $penjualan->save();

        return back()->with('success', 'Metode Pengiriman Disimpan');
    }

    // MEnampilkan halaman pembayaran
    public function pembayaranPelanggan(Penjualan $penjualan)
    {
        if($penjualan->metode_pengiriman != true){
            return back()->with('delete', 'Metode Pengiriman belum dipilih');
        }
        $penjualan->status_transaksi = 'Menunggu Pembayaran';
        $penjualan->save();

        return view('userPelanggan.pembayaranPelanggan', ['penjualan' => $penjualan]);
    }

    // upload filenya blm baru bikin ganti status ke menunggung konfirmasi
    public function uploadBuktiPembayaran(Request $request, Penjualan $penjualan){
        
        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:3072']
        ], [
            'bukti_pembayaran.required' => 'File harus diisi',
            'bukti_pembayaran.image' => 'File harus berupa gambar',
            'bukti_pembayaran.mimes' => 'Tipe file yang diunggah harus JPEG, PNG, JPG, atau GIF.',
            'bukti_pembayaran.max' => 'Ukuran file tidak boleh melebihi 3MB.'
        ]);

        if($request->hasFile('bukti_pembayaran')){
            $penjualan->bukti_pembayaran = $request->file('bukti_pembayaran')->store('bukti_pembayaran_pelanggan', 'public');
            $penjualan->status_transaksi = "Menunggu Konfirmasi Toko";
            $penjualan->save();

            return redirect()->route('daftarTransaksiUserPelanggan')->with('success', 'Pesanan diterima, menunggu konfirmasi pembayaran dari toko.');
        }        
    }

    public function selesai(Penjualan $penjualan)
    {   
        $penjualan->status_transaksi = 'Selesai';
        $penjualan->save();

        return back()->with('success', 'Transaksi Selesai');
    }
}
