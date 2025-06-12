<?php

namespace App\Http\Controllers;

use App\Models\IngredientQty;
use Illuminate\Http\Request;

class IngredientQtyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'IIQ_name' => 'required|string|max:255',
            'IIQ_name_kh' => 'required|string|max:255',
            'Menu_id' => 'required|exists:inv_material,Material_id', // Assuming this is the correct table
            'UOM_id' => 'required|exists:inv_uom,UOM_id',            // Assuming this is the correct table
            'Qty' => 'required|numeric|min:0',
        ]);

        IngredientQty::create([
            'IIQ_name' => $request->IIQ_name,
            'Material_id' => $request->Menu_id,
            'Qty' => $request->Qty,
            'UOM_id' => $request->UOM_id,
            'status' => 'Active' // default value or you can add a field for this in the form
        ]);

        return redirect()->back()->with('success', 'Ingredient added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IngredientQty  $ingredientQty
     * @return \Illuminate\Http\Response
     */
    public function show(IngredientQty $ingredientQty)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IngredientQty  $ingredientQty
     * @return \Illuminate\Http\Response
     */
    public function edit(IngredientQty $ingredientQty)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IngredientQty  $ingredientQty
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IngredientQty $ingredientQty)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IngredientQty  $ingredientQty
     * @return \Illuminate\Http\Response
     */
    public function destroy(IngredientQty $ingredientQty)
    {
        //
    }
}
