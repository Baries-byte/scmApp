<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BarangDibeli extends Model
{
    use HasFactory;

    protected $table = 'barang_dibeli';
    protected $fillable = ['barang_varian_id', 'jumlah'];

    public function varianBarang(): BelongsTo
    {
        return $this->belongsTo(VarianBarang::class);
    }
}
