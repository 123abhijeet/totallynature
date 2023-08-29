<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $action = route('admin.config.tax.store');
        $tax_detail = Tax::first(); 
        $method = 'post';
        $table  = "driver_list";
        return view('admin.config.tax.tax')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'tax_detail' => $tax_detail
        ]);
        return view('admin.config.tax.tax');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'tax' => 'required|unique:taxes|numeric',
        ]);

        Tax::updateOrCreate(
            [
                "status" => 1,
                'created_by'                => Auth::user()->id,
                // 'company_id'             =>,
            ],
            [
                "tax" => $request->tax
            ]
        );
        // echo json_encode(['status' => 'success', 'message' => "Tax Updated Successfully"]);
        return redirect()->back()->with(['success',"Tax Updated Successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_tax(Request $request)
    {
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
