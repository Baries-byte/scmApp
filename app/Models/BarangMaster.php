<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class BarangMaster extends Model
{
    use HasFactory;
    protected $table = 'barang_master';
    protected $fillable = ['nama_barang', 'merek', 'kategori_id', 'supplier_id'];

    public function varianBarang(): HasMany
    {
        return $this->hasMany(VarianBarang::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // public function detailPenjualan(): HasMany
    // {
    //     return $this->hasMany(DetailPenjualan::class);
    // }

    // public function detailPembelian(): HasMany
    // {
    //     return $this->hasMany(DetailPembelian::class);
    // }

    // public function persediaan(): HasOne
    // {
    //     return $this->hasOne(PersediaanBarang::class);
    // }

    // public function barangTerjual(): HasMany
    // {
    //     return $this->hasMany(BarangTerjual::class);
    // }

    // public function barangDibeli(): HasMany
    // {
    //     return $this->hasMany(BarangDibeli::class);
    // }

    public function scopeFilter($query, array $filters)
    {
        // dd($filters['kategori_id']);
        // if ($filters['kategori_id'] ?? false) {
        //     $query->where('kategori_id', 'like', '%' . request('kategori_id') . '%');
        // }

        if ($filters['search'] ?? false) {
            $query->where('nama_barang', 'like', '%' . request('search') . '%');
        }
    }

    public function deleteFoto()
    {
        Storage::delete($this->foto);
    }
}
