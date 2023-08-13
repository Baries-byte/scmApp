<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Satuan extends Model
{
    use HasFactory;
    protected $table = "satuan";
    protected $fillable = ["satuan"];

    public function varianBarang(): HasMany
    {
        return $this->hasMany(VarianBarang::class);
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['search'] ?? false) {
            $query->where('satuan', 'like', '%' . request('search') . '%');
        }
    }
}
