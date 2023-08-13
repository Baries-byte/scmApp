<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
    protected $fillable = ['supplier_id', 'total_item', 'status', 'pembayaran'];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
