<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersediaanBarang extends Model
{
    use HasFactory;
    protected $table = 'persediaan_barang';
    protected $fillable = ['varian_barang_id', 'persediaan_maks', 'persediaan_min', 'pembelian_optimal', 'persediaan'];

    public function varianBarang():BelongsTo
    {
        return $this->belongsTo(Barang::class);
    }
}
