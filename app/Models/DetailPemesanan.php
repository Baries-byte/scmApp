<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPemesanan extends Model
{
    use HasFactory;
    protected $table = 'detail_pemesanan';
    protected $fillable = ['pemesanan_id', 'barang_id', 'jumlah'];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
