<?php

namespace App\Http\Controllers;
use App\Models\Expense;
use App\Models\Project;
use App\Models\Invoice;
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
        $project = Project::where('project', $request->project)->first();

        $expense = Expense::create([
            'project_id' => $project->id,
            'item' => $request->item,
            'unit' => $request->unit,
            'price' => $request->price,
            'quantity' => $request->quantity
        ]);

        return redirect()->back();
    }

    public function show(Request $request, $id)
    {
        $projects = Project::findOrFail($id)->project;
        $expense = Expense::where('project_id', $id)->get();
        $invoices = Invoice::where('project_id', $id)->get();

        return view('expense.Expenses')->with([
            'projects' => $projects,
            'invoices' => $invoices,
            'expense' => $expense
        ]);
    }
}
