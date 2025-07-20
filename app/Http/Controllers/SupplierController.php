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

    public function store(Request $request)
    {
        $sup = Supplier::create([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'contact' => $request->contact,
            'tin' => $request->tin,
            'vrn' => $request->vrn,
            'category' => $request->category
        ]);

        return redirect()->back();
    }
}
