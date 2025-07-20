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
        return view('purchase.purchase', compact(['supl', 'project']));
    }
}
