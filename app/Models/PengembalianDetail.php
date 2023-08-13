<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengembalianDetail extends Model
{
    use HasFactory;
    protected $table = 'pengembalian_detail';
    protected $fillable = ['pengembalian_id', 'barang_supplier_id', 'jumlah_item'];

    public function pengembalian(): BelongsTo
    {
        return $this->belongsTo(Pengembalian::class);
    }

    public function barangSupplier(): BelongsTo
    {
        return $this->belongsTo(BarangSupplier::class);
    } 
}
