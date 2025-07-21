<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = ['supplier_id', 'item', 'unit', 'quantity', 'price'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
    use HasFactory;
}
