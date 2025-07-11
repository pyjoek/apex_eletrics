<?php

namespace App\Imports;

use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\ToModel;

class InvoicesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Invoice([
            'project_id' => $row[0],
            'item'       => $row[1],
            'unit'       => $row[2],
            'quantity'   => $row[3],
            'price'      => $row[4],
        ]);
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,xls']);
        
        Excel::import(new invoicesImport, $request->file('file'));

        return back()->with('success', 'invoice imported successfully.');
    }
}
