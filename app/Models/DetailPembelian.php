<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPembelian extends Model
{
    use HasFactory;
    protected $table = 'detail_pembelian';
    protected $fillable = ['pembelian_id', 'varian_barang_id', 'jumlah_item'];

    
    public function varianBarang(): BelongsTo
    {
        return $this->belongsTo(VarianBarang::class);
    }
    
    public function pembelian(): BelongsTo
    {
        return $this->belongsTo(Pembelian::class);
    }
}
