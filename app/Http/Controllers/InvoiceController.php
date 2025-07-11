<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $project = Project::all();
        $invoices = Invoice::all();
        return view('invoice.invoice', compact(['project', 'invoices']));
    }

    public function store(Request $request)
    {
        $proj = Project::where('project', $request->project)->first();

        $invoice = Invoice::create([
            'project_id' => $proj->id,
            'item' => $request->item,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        return redirect()->back();
    }
}
