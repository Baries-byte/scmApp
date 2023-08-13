<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BarangSupplier extends Model
{
    use HasFactory;
    protected $table = 'barang_supplier';
    protected $fillable = ['nama_barang', 'kode_barang', 'merek', 'harga_jual', 'deskripsi', 'supplier_id', 'foto'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detailPurchaseOrder(): HasMany
    {
        return $this->hasMany(DetailPurchaseOrder::class);
    }

    public function pengembalianDetail(): HasMany
    {
        return $this->hasMany(PengembalianDetail::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('nama_barang', 'like', '%' . request('search') . '%')
            ->orwhere('kode_barang', 'like', '%' . request('search') . '%');
        }
    }
}
