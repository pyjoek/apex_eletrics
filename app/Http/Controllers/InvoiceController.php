<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Customer;
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
        $customer = Customer::all();
        return view('invoice.invoice', compact(['project', 'invoices', 'customer']));
    }
    
    public function store(Request $request)
    {
        $proj = Project::where('project', $request->project)->first();
        $cust = Customer::where('name', $request->customer)->first();

        $invoice = Invoice::create([
            'project_id' => $proj->id,
            'customer_id' => $cust->id,
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

    public function exportPdf(Request $request, $id)
    {
        $project  = Project::findOrFail($id);
        // $invoices = Invoice::where('project_id', $id)->get();
        $invoices = Invoice::with('customer')->where('project_id', $id)->get();

        // dd($invoices->first()->customer->name);

        $termsInput = $request->input('terms');

        // Split each line into array items
        $terms = preg_split('/\r\n|\r|\n/', $termsInput);

        // Remove empty lines (optional)
        $terms = array_filter(array_map('trim', $terms));

        $data = [
            'title'    => $request->input('title'),
            'tax'      => $request->input('tax'),
            'discount' => $request->input('discount'),
            'terms'    => $terms
        ];

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);
        // return view('invoice.pdf', compact('project', 'invoices', 'total', 'data'));

        $pdf = Pdf::loadView('invoice.pdf', compact('project', 'invoices', 'total', 'data'));

        return $pdf->download('invoice.pdf');
    }

    public function profomaPDF(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $invoices = Invoice::where('project_id', $id)->get();

        $termsInput = $request->input('terms');

        // Split each line into array items
        $terms = preg_split('/\r\n|\r|\n/', $termsInput);

        // Remove empty lines (optional)
        $terms = array_filter(array_map('trim', $terms));

        $data = [
            'title'    => $request->input('title'),
            'tax'      => $request->input('tax'),
            'discount' => $request->input('discount'),
            'terms'    => $terms
        ];

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);

        $pdf = Pdf::loadView('invoice.proforma', compact('project', 'invoices', 'total', 'data'));
        // return view('invoice.pdf', compact('project', 'invoices', 'total', 'data'));

        return $pdf->download('proforma.pdf');
        // return $pdf->stream('proforma.pdf');
    }

     public function delivery(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $invoices = Invoice::where('project_id', $id)->get();

        $termsInput = $request->input('terms');

        // Split each line into array items
        $terms = preg_split('/\r\n|\r|\n/', $termsInput);

        // Remove empty lines (optional)
        $terms = array_filter(array_map('trim', $terms));

        $data = [
            'title'    => $request->input('title'),
            'tax'      => $request->input('tax'),
            'discount' => $request->input('discount'),
            'terms'    => $terms
        ];

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);

        $pdf = Pdf::loadView('invoice.delivery', compact('project', 'invoices', 'total', 'data'));
        return $pdf->download('delivery_note.pdf');
    }
}
