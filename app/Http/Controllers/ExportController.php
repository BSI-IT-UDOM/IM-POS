<?php

namespace App\Http\Controllers;

use App\Models\OrderInfor;
use App\Models\OrderDetail;
use App\Exports\OrderExport;
use App\Models\pos\POSOrderDetail;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportBill($id)
    {

        $order = OrderInfor::findOrFail($id);
        $details = POSOrderDetail::where('pos_order_id', $id)->get();
        $filename = 'Order_' . $order->Order_number . '.xlsx';
        return Excel::download(new OrderExport($order, $details), $filename);
    }
}
