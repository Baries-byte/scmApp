<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    protected $table = "supplier";
    protected $fillable = ["nama_perusahaan", "alamat", "telepon", "email", "user_id", "kode_supplier"];

    public function barangMaster(): HasMany
    {
        return $this->hasMany(BarangMaster::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // public function pemesanan(): HasMany
    // {
    //     return $this->hasMany(Pemesanan::class);
    // }

    public function barangSupplier(): HasMany
    {
        return $this->hasMany(BarangSupplier::class);
    }

    public function purchaseOrder(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }

    public function scopeFilter($query, array $filters){
        if($filters['search'] ?? false){
            $query->where('nama_perusahaan', 'like', '%' . request('search') . '%');
        }
    }
}
