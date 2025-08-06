<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['project'];

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }

    public function histinvoice()
    {
        return $this->hasMany(HistInvoice::class);
    }

    use HasFactory;
}
