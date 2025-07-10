<?php

namespace App\Http\Controllers;
use App\Models\Project;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProjectsExport;
use App\Imports\ProjectsImport;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
     public function index()
    {
        $projects = Project::all();
        return view('dashboard')->with(['projects' => $projects]);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new projectsImport, $request->file('file'));

        return back()->with('success', 'projects imported successfully.');
    }

    public function exportExcel()
    {
        return Excel::download(new projectsExport, 'projects.xlsx');
    }

    public function exportPDF()
    {
        $projects = Project::all();
        $pdf = Pdf::loadView('projects.pdf', compact('projects'));
        return $pdf->download('projects.pdf');
    }
}
