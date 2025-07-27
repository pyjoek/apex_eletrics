<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Exports\PurchaseExport;
use App\Imports\InvoicesImport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;


class PurchaseController extends Controller
{
    public function index()
    {
        $purchase = Purchase::all();
        $supplier = Supplier::all();
        return view('purchase.purchase', compact(['purchase', 'supplier']));
    }

    public function show()
    {
        $supplier = Supplier::all();
        return view('purchase.Purchase', compact(['supplier']));
    }

    public function all($id)
    {
        $supp = Purchase::where('supplier_id', $id)->get();
        return view('purchase.order', compact(['supp', 'id']));
    }

    public function store(Request $request)
    {
        $sup = Supplier::where('id', $request->supplier)->first();

        $purchase = Purchase::create([
            'supplier_id' => $request->supplier,
            'item' => $request->item,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        return redirect()->back();
    }

    public function exportPdf(Request $request, $id)
    {
        $project  = Supplier::findOrFail($id);
        // $invoices = Invoice::where('project_id', $id)->get();
        $invoices = Purchase::with('supplier')->where('supplier_id', $id)->get();

        // dd($invoices->first()->customer->name);

        $termsInput = $request->input('terms');

        // Split each line into array items
        $terms = preg_split('/\r\n|\r|\n/', $termsInput);

        // Remove empty lines (optional)
        $terms = array_filter(array_map('trim', $terms));

        $data = [
            'title'    => $request->input('title'),
            'terms'    => $terms
        ];

        $total = $invoices->sum(fn($inv) => $inv->price * $inv->quantity);
        // return view('purchase.pdf', compact('project', 'invoices', 'total', 'data'));

        $pdf = Pdf::loadView('purchase.pdf', compact('project', 'invoices', 'total', 'data'));

        return $pdf->download('purchase.pdf');
    }

    public function exportExcel($id)
    {
        return Excel::download(new PurchaseExport($id), 'invoices.xlsx');
    }
}
