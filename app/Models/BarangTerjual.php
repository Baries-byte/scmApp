<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BarangTerjual extends Model
{
    use HasFactory;
    protected $table = 'barang_terjual';
    protected $fillable = ['varian_barang_id', 'jumlah'];

    public function varianBarang(): BelongsTo
    {
        return $this->belongsTo(VarianBarang::class);
    }
}
