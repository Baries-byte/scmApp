<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Penjualan extends Model
{
    use HasFactory;
    protected $table = 'penjualan';
    protected $fillable = ['user_id', 'nama_pelanggan', 'alamat_pelanggan', 'telepon_pelanggan', 'total_item', 'total_harga', 'diskon', 'supir', 'bukti_pembayaran'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detailPenjualan(): HasMany
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function scopeFilter($query, array $filters)
    {
        // if ($filters['search_penjualan'] ?? false){
        //     $query->where('nama_pelanggan', 'like', '%' . request('search_penjualan') . '%');
        // }

        // if ($filters['search_penjualanAktif'] ?? false){
        //     $query->where('nama_pelanggan', 'like', '%' . request('search_penjualanAktif') . '%');
        // }

        if ($filters['search_penjualan_aktif'] ?? false){
                $query->where('kode_penjualan', 'like', '%' . request('search_penjualan_aktif') . '%');
            }
        if ($filters['search_penjualan_selesai'] ?? false){
                $query->where('kode_penjualan', 'like', '%' . request('search_penjualan_selesai') . '%');
            }
    }
}
