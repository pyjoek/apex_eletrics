<?php

namespace App\Http\Controllers;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchase = Purchase::all();
        $supplier = Supplier::all();
        return view('purchase.purchase', compact(['purchase', 'supplier']));
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
}
