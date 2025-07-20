<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    protected $fillable = ['project_id', 'price', 'unit' ,'quantity' ,'item'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    use HasFactory;
}
