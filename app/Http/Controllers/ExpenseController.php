<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Project;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $expense = Expense::all();
        $project = Project::all();
        return view('expense.expense', compact(['expense', 'project']));
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
