<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();
        return view('expense.expense', compact('expense'));
    }

    public function store(Request $request)
    {
        $expense = Expense::create([
            'project_id' => $request->project,
            'item' => $request->item,
            'amount' => $request->amount
        ]);

        return redirect()->back();
    }
}
