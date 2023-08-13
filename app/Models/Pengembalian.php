<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengembalian extends Model
{
    use HasFactory;
    protected $table = 'pengembalian';
    protected $fillable = ['purchase_order_id', 'catatan', 'total_item'];

    public function pengembalianDetail(): HasMany
    {
        return $this->hasMany(PengembalianDetail::class);
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
