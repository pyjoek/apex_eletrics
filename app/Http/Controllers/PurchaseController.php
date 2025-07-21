<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchase = Purchase::all();
        return view('purchase.purchase', compact('purchase'));
    }

    public function store(Request $request)
    {
        $purchase = Purchase::create([
            'supplier_id' => $supplier,
            'item' => $request->item,
            'unit' => $request->unit,
            'quantity' => $request->quantity,
            'price' => $request->price
        ]);

        return redirect()->back();
    }
}
