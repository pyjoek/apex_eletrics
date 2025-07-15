<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'address', 'contact', 'email', 'tin', 'vrn'];

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    use HasFactory;
}
