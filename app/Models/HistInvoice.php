<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistInvoice extends Model
{
    protected $fillable = ['project_id' , 'title', 'tax', 'discount', 'terms'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    use HasFactory;
}
