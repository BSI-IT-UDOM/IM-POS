<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Sale;
use App\Models\Addon;
use App\Models\Sales;
use App\Models\Report;
use App\Models\Invshop;
use App\Models\invSize;
use App\Models\Currency;
use App\Models\pos\MenuDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = Currency::all();
        return view('sales');
    }
    public function saleDetail(Request $request)
    {    $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $selectedLocation = $request->input('Location');
        $query = Report::query();
        if ($startDate && $endDate) {
            $query->whereBetween('Sale_date', [$startDate, $endDate]);
        }
        if ($selectedLocation) {
            $query->where('Location', $selectedLocation);
        }
        $report = $query->get();
        $locations = Report::select('Location')->distinct()->get(); 
        $menu = Menu::all();
        $currency = Currency::all();
        $addOns = Addon::all();
        $size = invSize::all();
        $menuDetail = MenuDetail::all();
        return view('salesDetail', compact('currency','menu','addOns','size','report','locations','menuDetail'));
    }
    public function store(Request $request)
    {        
        // dd($request->all());
        $numberOfMaterial = $request->selectnum;
        for ($i = 0; $i < $numberOfMaterial; $i++) {
            Sale::create([
                'Menu_id' => $request->input("inputSelectMenu".($i+1)),
                'Addons_id' => $request->input("inputSelectAddons".($i+1)),
                'Size_id' => $request->input("inputSelectSize".($i+1)),
                'Qty' => $request->input("qty".($i+1)),
                'price' => $request->input("price".($i+1)),
                'Currency_id' => $request->input("inputSelectCurrency".($i+1)),
                'S_id' => Auth::user()->invshop->S_id,
                'L_id' => Auth::user()->invLocation->L_id,
                'Sale_date' => $request->input("sale_date".($i+1)),
            ]);
        }
        return redirect()->back()->with('success', 'Sales detail created successfully!');
    }

}
