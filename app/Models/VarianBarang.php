<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VarianBarang extends Model
{
    use HasFactory;
    protected $table = 'varian_barang';
    protected $fillable = ['barang_master_id', 'nama_varian_barang', 'harga_beli', 'harga_beli', 'harga_jual', 'kode_barang', 'kode_produk', 'satuan_id', 'deskripsi', 'foto'];

    public function barangMaster(): BelongsTo
    {
        return $this->belongsTo(barangMaster::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function satuan(): BelongsTo
    {
        return $this->belongsTo(Satuan::class);
    }
    
    public function persediaan(): HasOne
    {
        return $this->hasOne(PersediaanBarang::class);
    }

    public function detailPenjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class, 'varian_barang_id', 'id');
    }

    public function detailPembelian(): HasMany
    {
        return $this->hasMany(DetailPembelian::class);
    }

    public function barangTerjual(): HasMany
    {
        return $this->hasMany(BarangTerjual::class);
    }

    public function barangDibeli(): HasMany
    {
        return $this->hasMany(BarangDibeli::class);
    }

    public function scopeFilter($query, array $filters)
    {
        // dd($filters['kategori_id']);
        if ($filters['kategori_id'] ?? false) {
            $query->where('kategori_id', 'like', '%' . request('kategori_id') . '%');
        }

        if ($filters['search'] ?? false) {
            $query->where('nama_varian_barang', 'like', '%' . request('search') . '%')
            ->orWhere('kode_barang', 'like', '%' . request('search') . '%')
            ->orWhere('kode_produk', 'like', '%' . request('search') . '%');
        }
    }
}
