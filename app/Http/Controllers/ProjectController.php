<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\HistInvoice;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use App\Imports\ProjectsImport;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
     public function index()
    {
        $projects = Project::all();
        $supplier = Supplier::all();
        $customer = Customer::all();
        return view('dashboard')->with(['projects' => $projects, 'supplier' => $supplier, 'customer' => $customer]);
    }

    public function show(Request $request, $id)
    {
        $projects = Project::findOrFail($id);
        $hist = HistInvoice::where('project_id', $id)->get();
        $invoices = Invoice::where('project_id', $projects->id)->get();

        return view('work')->with([
            'projects' => $projects,
            'invoices' => $invoices,
            'id' => $id,
            'hist' => $hist
        ]);
    }

    public function oldInvoice(Request $request)
    {
        $projects = Project::findOrFail($request->id);
        $invoices = Invoice::where('project_id', $projects->id)->get();

        return view('work')->with([
            'projects' => $projects,
            'invoices' => $invoices,
        ]);
    }

    public function store(Request $request) {
        $project = Project::create([
            'project' => $request->project,
        ]);

        return redirect()->back();
    }

    public function invoice()
    {
        $projects = Project::all();
        return view('invoice.invoice')->with(['projects' => $projects]);
    }

    // export and importing starts here
    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new projectsImport, $request->file('file'));

        return back()->with('success', 'projects imported successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new projectsExport, 'projects.xlsx');
    }

    public function exportPDF()
    {
        $projects = Project::all();
        $pdf = Pdf::loadView('invoice.pdf', compact('projects'));
        return $pdf->download('projects.pdf');
    }
}
