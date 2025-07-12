<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Invoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;
use App\Imports\InvoicesImport;
use Barryvdh\DomPDF\Facade\Pdf;
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

    // export and importing starts here
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new InvoicesImport, $request->file('file'));

        return back()->with('success', 'invoices imported successfully.');
    }

    public function exportExcel($id)
    {
        return Excel::download(new InvoicesExport($id), 'invoices.xlsx');
    }

    public function exportPDF($id)
    {
        $project = Project::findOrFail($id);
        $invoices = Invoice::where('project_id', $id)->get();

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);

        $pdf = Pdf::loadView('invoice.pdf', compact('project', 'invoices', 'total'));

        return $pdf->download('invoices.pdf');
    }

    public function profomaPDF($id)
    {
        $project = Project::findOrFail($id);
        $invoices = Invoice::where('project_id', $id)->get();

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);

        $pdf = Pdf::loadView('invoice.proforma', compact('project', 'invoices', 'total'));
        return $pdf->download('proforma.pdf');
    }

     public function delivery($id)
    {
        $project = Project::findOrFail($id);
        $invoices = Invoice::where('project_id', $id)->get();

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);

        $pdf = Pdf::loadView('invoice.delivery', compact('project', 'invoices', 'total'));
        return $pdf->download('delivery_note.pdf');
    }
}
