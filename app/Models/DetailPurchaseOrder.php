<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPurchaseOrder extends Model
{
    use HasFactory;
    protected $table = 'detail_purchase_order';
    protected $fillable = ['purchase_order_id', 'barang_supplier_id', 'jumlah_item', 'sub_total'];

    public function barangSupplier(): BelongsTo
    {
        return $this->belongsTo(BarangSupplier::class);
    } 

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
