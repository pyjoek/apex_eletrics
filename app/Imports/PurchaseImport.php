<?php

namespace App\Imports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\ToModel;

class PurchaseImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {dd($row);
        return new Purchase([
            'supplier_id' => $row[0],
            'item'       => $row[1],
            'unit'       => $row[2],
            'quantity'   => $row[3],
            'price'      => $row[4],
        ]);
    }
}
