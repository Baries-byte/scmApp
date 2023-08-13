<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use HasFactory;
    protected $table = "kategori";
    protected $fillable = ["kategori"];

    public function barangMaster(): HasMany
    {
        return $this->hasMany(BarangMaster::class);
    }

    public function varianBarang(): HasMany
    {
        return $this->hasMany(VarianBarang::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('kategori', 'like', '%' . request('search') . '%');
        }
    }
}
