<?php

namespace App\Http\Controllers\Admin\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function service_list()
    {
        $data = Service::orderBy('service_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.fleet.service.edit', $item->service_id);
            $delete = route('admin.fleet.service.destroy', $item->service_id);

            $table = "service_list";

            $action = ' <ul class="nav-item dropdown pe-3">
    
                <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
      
                <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Service`)">
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
                $item->service_id,
                $item->date,
                $item->description,
                $item->service_type,
                $item->vehicle_id,
                $item->driver_id,
                $item->notes,
                $item->cost,
                $user_details->name,
                $action,
            );
            $action = '';
        }
        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }
    public function index()
    {
        return view('admin.fleet.services.services');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.fleet.service.store');
        $method = 'post';
        $table  = "service_list";
        return view('admin.fleet.services.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'description'  => '',
            'service_type'  => '',
        ]);
       
        if (!empty($request->invoice_file)) {
            $invoicefile = '';
            $imageName = time() . '1'. '.' . $request->invoice_file->extension();
            $invoicefile = $request->invoice_file->storeAs('Fleet/Service', $imageName);
        }
        if (!empty($request->odometer_file)) {
            $odometerfile = '';
            $imageName = time() . '2' . '.'  . $request->odometer_file->extension();
            $odometerfile = $request->odometer_file->storeAs('Fleet/Service', $imageName);
        }
        Service::create([
            'description'           => $request->description,
            'service_type'          => $request->service_type,
            'driver_id'             => $request->driver_id,
            'vehicle_id'            => $request->vehicle_id,
            'date'                  => $request->date,
            'odometer_value'        => $request->odometer_value,
            'cost'                  => $request->cost,
            'invoice_file'          => $invoicefile,
            'odometer_file'         => $odometerfile,
            'notes'                 => $request->notes,
            'created_by'            => Auth::user()->id,
            // 'company_id'    =>,
        ]);
        echo json_encode(['status' => 'success', 'message' => "Service Created Successfully"]);
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
        $data = Service::where('service_id', $id)->first();
        $action = route('admin.fleet.update_service');
        $method = 'post';
        $table  = "service_list";
        return view('admin.fleet.services.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function update_service(Request $request)
    {
        $request->validate([
            'description'  => '',
            'service_type'  => '',
        ]);
        $old_service_data =  Service::find($request->service_id);

        if (!empty($request->invoice_file)) {
            $invoicefile = '';
            $imageName = time() . '1'. '.' . $request->invoice_file->extension();
            $invoicefile = $request->invoice_file->storeAs('Fleet/Service', $imageName);
        }else{
            $invoicefile = $old_service_data->invoice_file;
        }
        if (!empty($request->odometer_file)) {
            $odometerfile = '';
            $imageName = time() . '2' . '.'  . $request->odometer_file->extension();
            $odometerfile = $request->odometer_file->storeAs('Fleet/Service', $imageName);
        }else{
            $odometerfile = $old_service_data->odometer_file;
        }
        
        Service::where('service_id',$request->service_id)->update([
            'description'           => $request->description,
            'service_type'          => $request->service_type,
            'driver_id'             => $request->driver_id,
            'vehicle_id'            => $request->vehicle_id,
            'date'                  => $request->date,
            'odometer_value'        => $request->odometer_value,
            'cost'                  => $request->cost,
            'invoice_file'          => $invoicefile,
            'odometer_file'         => $odometerfile,
            'notes'                 => $request->notes,
        ]);
        echo json_encode(['status' => 'success', 'message' => "Service Details Updated Successfully"]); 
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Service::where('service_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Service Details Deleted Successfully"]);
    }
}
