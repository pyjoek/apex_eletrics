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
use App\Imports\PurchaseImport;
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

    public function invoiceView()
    {
        $projects = Project::all();
        return view('invoice.formInvoice')->with(['projects' => $projects]);
    }

    public function show(Request $request, $id)
    {

        $projects = Project::findOrFail($id);
        $customer = Customer::all();
        $allprojects = Project::all();
        $hist = HistInvoice::where('project_id', $id)->get();
        $invoices = Invoice::where('project_id', $projects->id)->get();
        // dd($hist->first()->id);

        return view('work')->with([
            'allprojects' => $allprojects,
            'allcustomers' => $customer,
            'projects' => $projects,
            'invoices' => $invoices,
            'id' => $id,
            'hist' => $hist
        ]);
    }

     public function invoiceHistory(Request $request, $id)
    {
        $projects = Project::findOrFail($id);
        $customer = Customer::all();
        $allprojects = Project::all();
        $hist = HistInvoice::where('project_id', $id)->get();
        $invoices = Invoice::where('project_id', $projects->id)->get();
        // dd($hist);

        return view('work')->with([
            'allprojects' => $allprojects,
            'allcustomers' => $customer,
            'projects' => $projects,
            'invoices' => $invoices,
            'id' => $id,
            'hist' => $hist
        ]);
    }

    public function oldInvoice($id)
    {
        $hist = HistInvoice::findOrFail($id);
        $projects = Project::where('id', $hist->project_id)->first();
        $invoices = Invoice::where('project_id', $projects->id)->get();

        return view('old')->with([
            'projects' => $projects,
            'invoices' => $invoices,
            'hist' => $hist
        ]);
    }

    public function destroy($id)
    {
        // Find the record or throw 404
        $hist = HistInvoice::findOrFail($id);

        // Delete the historical invoice
        $hist->delete();

        // Redirect back with a success message
        return redirect()
            ->back() // Adjust to your route
            ->with('success', 'Historical invoice deleted successfully.');
    }

    public function destroys($id)
    {
        // Find the record or throw 404
        $hist = Project::findOrFail($id);

        // Delete the historical invoice
        $hist->delete();

        // Redirect back with a success message
        return redirect()
            ->back() // Adjust to your route
            ->with('success', 'Historical invoice deleted successfully.');
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

    public function imports(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new PurchaseImport, $request->file('file'));

        return back()->with('success', 'orders imported successfully.');
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
