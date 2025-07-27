<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;

class PurchaseExport implements FromCollection
{
    protected $supplier_id;

    public function __construct($supplier_id)
    {
        $this->supplier_id = $supplier_id;
    }

    public function collection()
    {
        return Purchase::where('supplier_id', $this->supplier_id)
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
