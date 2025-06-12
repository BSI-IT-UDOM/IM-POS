<?php

namespace App\Exports;

use App\Models\OrderInfor;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrderExport implements FromArray, WithHeadings
{
    protected $order;
    protected $details;

    public function __construct($order, $details)
    {
        $this->order = $order;
        $this->details = $details;
    }

public function array(): array
{
    $data = [];

    foreach ($this->details as $index => $item) {
        $data[] = [
            'No.'         => $index + 1,
            'Menu Name'   => optional($item->Menu)->Menu_name_eng . ' ' . optional($item->Addons)->Addons_name . ' ' . optional($item->Size)->Size_name,
            'Qty'         => $item->Qty,
            'Price'       => $item->price,
        ];
    }

    $orderData = is_array($this->order) ? $this->order[0] : $this->order->first();
    $data[] = [''];
    $data[] = ['Sub Total', $orderData->sub_total ?? 0.00];
    $data[] = ['Discount (%)', $orderData->discount_amount ?? 0.00];
    $data[] = ['Grand Total', $orderData->grand_total ?? 0.00];

    return $data;
}


    public function headings(): array
    {
        return ['No.', 'Menu Name', 'Qty', 'Price'];
    }
}
