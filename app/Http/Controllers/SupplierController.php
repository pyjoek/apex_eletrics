<?php

namespace App\Http\Controllers;
use App\Models\Supplier;
use App\Models\Project;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $supl = Supplier::all();
        $project = Project::all();
        return view('expense.expense', compact(['supl', 'project']));
    }

    public function store()
    {
        
    }
}
