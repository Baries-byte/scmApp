<?php
function format_uang($nominal)
{
  return number_format($nominal, 0, ',', '.');
}

function terbilang($nominal)
{
  $nominal = abs($nominal);
  $baca = array(' ', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
  $terbilang = '';

  if ($nominal < 12) { // 1 -- 11
    $terbilang = ' ' . $baca[$nominal];
  } elseif ($nominal < 20) { //12 -- 19
    $terbilang = terbilang($nominal - 10) . ' belas';
  } elseif ($nominal < 100) { // 20 -- 99
    $terbilang = terbilang($nominal / 10) . ' puluh' . terbilang($nominal % 10);
  } elseif ($nominal < 200) { // 100 -- 199
    $terbilang = ' seratus' . terbilang($nominal - 100);
  } elseif ($nominal < 1000) { // 200 -- 999
    $terbilang = terbilang($nominal / 100) . ' ratus' . terbilang($nominal % 100);
  } elseif ($nominal < 2000) { // 1000 -- 1.999
    $terbilang = ' seribu' . terbilang($nominal - 1000);
  } elseif ($nominal < 1000000) { // 2.000 -- 999.999
    $terbilang = terbilang($nominal / 1000) . ' ribu' . terbilang($nominal % 1000);
  } elseif ($nominal < 1000000000) { // 1.000.000 -- 999.999.999
    $terbilang = terbilang($nominal / 1000000) . ' juta' . terbilang($nominal % 1000000);
  }

  return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
  $nama_hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu');
  $nama_bulan = array(1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');

  $tahun = substr($tgl, 0, 4);
  $bulan = $nama_bulan[(int) substr($tgl, 5, 2)];
  $tanggal = substr($tgl, 8, 2);
  $text = '';

  if ($tampil_hari) {
    $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
    $hari = $nama_hari[$urutan_hari];
    $text .= "$hari, $tanggal $bulan $tahun";
  } else {
    $text .= "$tanggal $bulan $tahun";
  }

  return $text;
}

function bulan_indonesia($nomorBulan)
{
  $bulan = [
    1 => 'Januari',
    2 => 'Februari',
    3 => 'Maret',
    4 => 'April',
    5 => 'Mei',
    6 => 'Juni',
    7 => 'Juli',
    8 => 'Agustus',
    9 => 'September',
    10 => 'Oktober',
    11 => 'November',
    12 => 'Desember',
];

return $bulan[$nomorBulan] ?? '';
}

function kodeSupplier($namaPerusahaan) {
  $kata = explode(' ', $namaPerusahaan); // Memisahkan kata-kata dalam nama perusahaan
  $jumlahKata = count($kata);

  if ($jumlahKata >= 2) {
      $kataPertama = strtoupper(substr($kata[0], 0, 2)); // Mengambil 2 huruf dari kata pertama
      $kataKedua = strtoupper(substr($kata[1], 0, 3)); // Mengambil 3 huruf dari kata kedua

      $kodeSupplier = $kataPertama . $kataKedua;
  } else {
      $kodeSupplier = strtoupper(substr($namaPerusahaan, 0, 5)); // Mengambil 5 huruf pertama jika hanya terdapat satu kata
  }

  return $kodeSupplier;
}

function kodeBarang($kodeSupplier, $idKategori, $idBarang)
{
  $kodeSupplier = strtoupper($kodeSupplier);
  $idKategori = str_pad($idKategori, 2, '0', STR_PAD_LEFT);
  $idBarang = str_pad($idBarang, 4, '0', STR_PAD_LEFT);

  $kodeBarang = $kodeSupplier . $idKategori . $idBarang;

  return $kodeBarang;
}

function kodePenjualan($userLevel, $userId, $nomorUrut)
{
  $kodePenjualan = "";
  $nomorUrut += 1;

  if($userLevel == 1 or $userLevel == 2){
    $kodePenjualan .= "OF";
  } elseif ($userLevel == 0){
    $kodePenjualan .= "ON";
  }

  $kodePenjualan .= date('dmy');
  $kodePenjualan .= str_pad($userLevel, 2, '0', STR_PAD_LEFT);
  $kodePenjualan .= str_pad($userId, 3, '0', STR_PAD_LEFT);
  $kodePenjualan .= str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);

  return $kodePenjualan;
}

function kodePurchaseOrder($kodeSupplier, $userLevel, $userId, $nomorUrut)
{
  $kodePO = "PO";
  $nomorUrut += 1;
  $kodePO .= $kodeSupplier;
  $kodePO .= date("dmy");
  $kodePO .= str_pad($userLevel, 2, '0', STR_PAD_LEFT);
  $kodePO .= str_pad($userId, 3, '0', STR_PAD_LEFT);
  $kodePO .= str_pad($nomorUrut, 2, '0', STR_PAD_LEFT);

  return $kodePO;
}

function hitungEOQ($permintaan, $biayaPembelian, $biayaPenyimpanan)
{
  if($biayaPenyimpanan != 0)
  {
    $EOQ =  sqrt((2 * $permintaan * $biayaPembelian) / $biayaPenyimpanan);

    return $EOQ;
  }

  $error = "Error terjadi karena biaya penyimpanan 0";
  return $error;
}

function hitungROP($kebutuhanSetahun, $waktuTunggu)
{
  $rataHariKerjaSetahun = 300;
  $kebutuhanSehari = $kebutuhanSetahun / $rataHariKerjaSetahun;

  $ROP = $kebutuhanSehari * $waktuTunggu;

  return $ROP;
}