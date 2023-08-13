<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailPenjualan extends Model
{
    use HasFactory;
    protected $table = 'detail_penjualan';
    protected $fillable = ['penjualan_id', 'varian_barang_id', 'jumlah_item', 'harga_satuan', 'sub_total'];

    // public function varianBarang(): BelongsTo
    // {
    //     return $this->belongsTo(VarianBarang::class);
    // }

    public function varianBarang(): BelongsTo
    {
        return $this->belongsTo(VarianBarang::class, 'varian_barang_id', 'id');
    }
    public function penjualan(): BelongsTo
    {
        return $this->belongsTo(Penjualan::class);
    }
}
