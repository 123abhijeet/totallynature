<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseSubLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.config.warehouse.warehouse');
    }

    function warehouse_list()
    {
        $data = Warehouse::orderBy('warehouse_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.config.warehouse.edit', $item->warehouse_id);
            $delete = route('admin.config.warehouse.destroy', $item->warehouse_id);

            $table = "warehouse_list";

            $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Warehouse`)">
                <i class="bi bi-pencil-square"></i>
                  <span>Edit</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="delete_modal(`' . $delete . '`,`' . $table . '`)">
                <i class="bi bi-trash3"></i>
                  <span>Delete</span>
                </a>
              </li>
            </ul>
          </ul>';
            $user_details = User::find($item->created_by);
            $new_data[] = array(
                $item->warehouse_id,
                $item->warehouse_code,
                $item->warehouse_name,
                $user_details->name,
                $action,
            );
            $action = '';
        }
        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"       => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.config.warehouse.store');
        $method = 'post';
        $table  = "warehouse_list";
        return view('admin.config.warehouse.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table
        ]);
    }
    public function warehouse_sub_location_list(){
        $data = WarehouseSubLocation::where('warehouse_id',request()->id)->get();
        echo json_encode($data);    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'warehouse_code'    => 'required|unique:warehouses,warehouse_code',
            'warehouses_name'   => 'required|unique:warehouses,warehouse_name'
        ]);

        $data = Warehouse::insertGetId([
            'warehouse_code'        => $request->warehouse_code,
            'warehouse_name'       => $request->warehouses_name,
            'created_by'            => Auth::user()->id,
            // 'company_id'    =>,
            'created_at'            => now(),
            'updated_at'            => now()
        ]);

        foreach ($request->warehouses_sub_location as $key => $item) {
            WarehouseSubLocation::create([
                'warehouse_id'          => $data,
                'sub_location'          => $item,
                'created_by'            => Auth::user()->id,
                // 'company_id
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => "Warehouse Create Successfully"]);
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
        $data = Warehouse::where('warehouse_id', $id)->first();
        $action = route('admin.config.update_warehouse');
        $method = 'post';
        $table  = "warehouse_list";
        $sub_location = WarehouseSubLocation::where('warehouse_id', $id)->get();

        return view('admin.config.warehouse.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
            'sub_location'       => $sub_location
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_warehouse(Request $request)
    {
        $request->validate([
            'warehouse_code'    => 'required|unique:warehouses,warehouse_code,' . $request->warehouse_id . ',warehouse_id',
            'warehouses_name'   => 'required|unique:warehouses,warehouse_name,' . $request->warehouse_id . ',warehouse_id',
        ]);

        Warehouse::where('warehouse_id', $request->warehouse_id)->update([
            'warehouse_code'        => $request->warehouse_code,
            'warehouse_name'       => $request->warehouses_name,
        ]);

        foreach ($request->warehouses_sub_location as $key => $item) {
            $check = WarehouseSubLocation::where('warehouse_sub_location_id', $request->warehouses_sub_location_id[$key])->first();
            WarehouseSubLocation::whereNotIn('warehouse_sub_location_id', $request->warehouses_sub_location_id)->where('warehouse_id', $request->warehouse_id)->delete();
            if ($check) {
                WarehouseSubLocation::where('warehouse_sub_location_id', $request->warehouses_sub_location_id[$key])->update([
                    'sub_location'      => $item,
                ]);
            } else {
                WarehouseSubLocation::create([
                    'warehouse_id'          => $request->warehouse_id,
                    'sub_location'          => $request->warehouses_sub_location[$key],
                    'created_by'            => Auth::user()->id,
                    // 'company_id
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Warehouse Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Warehouse::where('warehouse_id', $id)->delete();
        WarehouseSubLocation::where('warehouse_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Warehouse Delete Successfully"]);
    }
}
