<?php

namespace App\Exports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;

class InvoicesExport implements FromCollection
{
    protected $project_id;

    public function __construct($project_id)
    {
        $this->project_id = $project_id;
    }

    public function collection()
    {
        return Invoice::where('project_id', $this->project_id)
                      ->select('item', 'unit', 'quantity', 'price')
                      ->get();
    }

    public function headings(): array
    {
        return ['Item', 'Unit', 'Quantity', 'Price'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Invoice::all();
    // }


}
