<?php

namespace App\Http\Controllers\Admin\Fleet;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Vehicledocument;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Image;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function expired_documents()
    {
        return view('admin.fleet.dashboard');
    }

    public function expired_document_list()
    {
        $data = Vehicle::join('vehicledocuments', 'vehicledocuments.vehicle_id', '=', 'vehicles.vehicle_id')
            ->where('vehicledocuments.document_expiry_date', '<', Carbon::today())
            ->select('vehicledocuments.document_expiry_date as document_expiry_date', 'vehicles.vehicle_modal as vehicle_modal', 'vehicles.created_by as created_by', 'vehicles.license_plate as license_plate', 'vehicledocuments.document_title as document_title', 'vehicledocuments.document_issue_date as document_issue_date')
            ->get();
        $new_data = array();

        foreach ($data as $item) {

            $user_details = User::find($item->created_by);
            $new_data[] = array(
                $item->document_title,
                $item->vehicle_modal,
                $item->license_plate,
                $item->document_issue_date,
                $item->document_expiry_date,
                $user_details->name,
            );
        }
        $output = array(
            "draw"                 => request()->draw,
            "recordsTotal"         => $data->count(),
            "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }
    public function vehicle_list()
    {
        $data = Vehicle::orderBy('vehicle_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.fleet.vehicle.edit', $item->vehicle_id);
            $delete = route('admin.fleet.vehicle.destroy', $item->vehicle_id);

            $table = "vehicle_list";

            $action = ' <ul class="nav-item dropdown pe-3">
    
                <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
      
                <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Vehicle`)">
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
                $item->vehicle_id,
                $item->vehicle_modal,
                $item->license_plate,
                $item->fuel_type,
                $item->servicing_status ? $item->servicing_status : 'N/A',
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
        return view('admin.fleet.vehicle.vehicle');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.fleet.vehicle.store');
        $method = 'post';
        $table  = "vehicle_list";
        return view('admin.fleet.vehicle.modal.add_edit')->with([
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
            'vehicle_modal'  => 'required',
            'license_plate'  => 'required|unique:vehicles,license_plate',
        ]);
        $data = Vehicle::insertGetId([
            'vehicle_modal'             => $request->vehicle_modal,
            'license_plate'             => $request->license_plate,
            'current_odometer'          => $request->current_odometer,
            'last_odometer'             => $request->last_odometer,
            'next_servicing_odometer'   => $request->next_servicing_odometer,
            'servicing_status'          => $request->servicing_status,
            'model_year'                => $request->model_year,
            'model_color'               => $request->model_color,
            'horsepower'                => $request->horsepower,
            'fuel_type'                 => $request->fuel_type,
            'created_by'                => Auth::user()->id,
            // 'company_id'    =>,
            'created_at'            => now(),
            'updated_at'            => now()
        ]);
        foreach ($request->document_title as $key => $item) {
            $file = '';
            if (!empty($request->document_file[$key])) {
                $imageName = time() . '.' . $request->document_file[$key]->extension();
                $file = $request->document_file[$key]->storeAs('Fleet/Vehicle', $imageName);
            }
            Vehicledocument::create([
                'document_title'           => $item,
                'document_issue_date'      => $request->document_issue_date[$key],
                'document_expiry_date'     => $request->document_expiry_date[$key],
                'document_file'            => $file,
                'vehicle_id'               => $data,
                'created_by'               => Auth::user()->id,
                // 'company_id
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => "Vehicle Created Successfully"]);
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
        $data = Vehicle::where('vehicle_id', $id)->first();
        $action = route('admin.fleet.update_vehicle');
        $method = 'post';
        $table  = "vehicle_list";
        $vehicles = Vehicledocument::where('vehicle_id', $id)->get();
        return view('admin.fleet.vehicle.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
            'vehicles'       => $vehicles
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_vehicle(Request $request)
    {
        $request->validate([
            'vehicle_modal'  => 'required',
            'license_plate'  => 'required|unique:vehicles,license_plate',
            'license_plate'  => [
                'required',
                Rule::unique('vehicles')->ignore($request->vehicle_id, 'vehicle_id')
            ]
        ]);

        Vehicle::where('vehicle_id', $request->vehicle_id)->update([
            'vehicle_modal'             => $request->vehicle_modal,
            'license_plate'             => $request->license_plate,
            'current_odometer'          => $request->current_odometer,
            'last_odometer'             => $request->last_odometer,
            'next_servicing_odometer'   => $request->next_servicing_odometer,
            'servicing_status'          => $request->servicing_status,
            'model_year'                => $request->model_year,
            'model_color'               => $request->model_color,
            'horsepower'                => $request->horsepower,
            'fuel_type'                 => $request->fuel_type,
        ]);

        foreach ($request->document_title as $key => $item) {
            $check = Vehicledocument::where('vehicle_document_id', $request->vehicle_document_id[$key] ?? '')->first();
            Vehicledocument::whereNotIn('vehicle_document_id', $request->vehicle_document_id)->where('vehicle_id', $request->vehicle_id)->delete();
            if ($check) {
                $file = '';
                if (!empty($request->document_file[$key])) {
                    $imageName = time() . '.' . $request->document_file[$key]->extension();
                    $file = $request->document_file[$key]->storeAs('Fleet/Vehicle', $imageName);
                } else {
                    $file = $check->document_file;
                }
                Vehicledocument::where('vehicle_document_id', $request->vehicle_document_id[$key])->update([
                    'document_title'           => $item,
                    'document_issue_date'      => $request->document_issue_date[$key],
                    'document_expiry_date'     => $request->document_expiry_date[$key],
                    'document_file'            => $file,
                ]);
            } else {
                $file = '';
                if (!empty($request->document_file[$key])) {
                    $imageName = time() . '.' . $request->document_file[$key]->extension();
                    $file = $request->document_file[$key]->storeAs('Fleet/Vehicle', $imageName);
                }
                Vehicledocument::create([
                    'vehicle_id'               => $request->vehicle_id,
                    'document_title'           => $item,
                    'document_issue_date'      => $request->document_issue_date[$key],
                    'document_expiry_date'     => $request->document_expiry_date[$key],
                    'document_file'            => $file,
                    'created_by'               => Auth::user()->id,
                    // 'company_id
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Vehicle Details Update Successfully"]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Vehicle::where('vehicle_id', $id)->delete();
        Vehicledocument::where('vehicle_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Vehicle Details Delete Successfully"]);
    }
}
