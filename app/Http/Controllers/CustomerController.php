<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function store(Request $request) {
        $user = Customer::create([
            'name' => $request->name,
            'address' => $request->address,
            'contact' => $request->contact,
            'email' => $request->email,
            'tin' => $request->tin,
            'vrn' => $request->vrn,
        ]);

        return redirect()->back();
    }
}
