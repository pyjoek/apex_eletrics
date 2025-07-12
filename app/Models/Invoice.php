<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'item', 'unit', 'quantity', 'price'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function expense()
    {
        return $this->hasMany(Expense::class);
    }
}
