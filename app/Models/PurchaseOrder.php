<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'purchase_order';
    protected $fillable = ['supplier_id', 'total_item', 'kode_purchse_order', 'kode_purchase_order_supplier', 'total_harga', 'status', 'foto_surat_jalan', 'foto_bukti_peneriamaan', 'foto_invoce_pembelian'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailPurchaseOrder(): HasMany
    {
        return $this->hasMany(DetailPurchaseOrder::class);
    }

    public function pembelian(): HasOne
    {
        return $this->hasOne(Pembelian::class);
    }

    public function pengembalian(): HasOne
    {
        return $this->hasOne(Pengembalian::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if($filters['search'] ?? false){
            $query->where('kode_purchase_order', 'like', '%' . request('search') . '%');
        }
    }
}
