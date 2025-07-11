<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Invoice::all();
    }

    public function exportExcel()
    {
        return Excel::download(new InvoiceExport, 'projects.xlsx');
    }

    public function exportPDF()
    {
        $projects = Invoice::all();
        $pdf = Pdf::loadView('invoice.pdf', compact('invoice'));
        return $pdf->download('invoice.pdf');
    }
}
