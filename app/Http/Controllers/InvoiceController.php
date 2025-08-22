<?php

namespace App\Http\Controllers;
use App\Models\Project;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\HistInvoice;
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
        $invoices = $request->input('invoices');

        if (is_array($invoices)) {
            foreach ($invoices as $invoiceData) {
                Invoice::create([
                    'project_id'  => is_array($invoiceData['project'] ?? null) ? ($invoiceData['project'][0] ?? $request->project) : ($invoiceData['project'] ?? $request->project),
                    'customer_id' => is_array($invoiceData['customer'] ?? null) ? ($invoiceData['customer'][0] ?? $request->customer) : ($invoiceData['customer'] ?? $request->customer),
                    'item'        => is_array($invoiceData['item'] ?? null) ? ($invoiceData['item'][0] ?? null) : ($invoiceData['item'] ?? null),
                    'unit'        => is_array($invoiceData['unit'] ?? null) ? ($invoiceData['unit'][0] ?? null) : ($invoiceData['unit'] ?? null),
                    'quantity'    => is_array($invoiceData['quantity'] ?? null) ? ($invoiceData['quantity'][0] ?? null) : ($invoiceData['quantity'] ?? null),
                    'price'       => is_array($invoiceData['price'] ?? null) ? ($invoiceData['price'][0] ?? null) : ($invoiceData['price'] ?? null),
                ]);
            }
        } else {
            Invoice::create([
                'project_id'  => is_array($request->project) ? ($request->project[0] ?? null) : $request->project,
                'customer_id' => is_array($request->customer) ? ($request->customer[0] ?? null) : $request->customer,
                'item'        => is_array($request->item) ? ($request->item[0] ?? null) : $request->item,
                'unit'        => is_array($request->unit) ? ($request->unit[0] ?? null) : $request->unit,
                'quantity'    => is_array($request->quantity) ? ($request->quantity[0] ?? null) : $request->quantity,
                'price'       => is_array($request->price) ? ($request->price[0] ?? null) : $request->price
            ]);
        }

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
        $history = HistInvoice::create([
            'project_id' => $request->id,
            'title' => $request->title,
            'tax' => $request->tax,
            'discount' => $request->discount,
            'terms' => $request->terms,
        ]);

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
        // return view('invoice.proforma', compact('project', 'invoices', 'total', 'data'));

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
        return view('invoice.delivery', compact('project', 'invoices', 'total', 'data'));

        return $pdf->download('delivery_note.pdf');
    }
}
