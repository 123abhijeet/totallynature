<?php

namespace App\Http\Controllers\Admin\Logistic;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Driverdocument;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getlicense_plate(Request $request)
    {
        $getlicense_plate_data = Vehicle::where('vehicle_id', $request->vehicle_id)->first();
        return response()->json($getlicense_plate_data);
    }
    public function driver_list()
    {
        $data = Driver::join('vehicles', 'vehicles.vehicle_id', 'drivers.vehicle_id')
            ->select('drivers.*', 'vehicles.vehicle_modal as vehicle_modal')
            ->orderBy('driver_id', 'desc')
            ->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.logistic.driver.edit', $item->driver_id);
            $delete = route('admin.logistic.driver.destroy', $item->driver_id);

            $table = "driver_list";

            $action = ' <ul class="nav-item dropdown pe-3">
    
                <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
      
                <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Driver`)">
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
                $item->driver_id,
                $item->username,
                $item->driver_name,
                $item->mobile_number,
                $item->region,
                $item->vehicle_modal,
                $item->license_plate,
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
        return view('admin.logistic.driver.driver');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.logistic.driver.store');
        $method = 'post';
        $table  = "driver_list";
        return view('admin.logistic.driver.modal.add_edit')->with([
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
            'username'  => 'unique:drivers,username',
            'email'  => 'unique:drivers,email',
            'mobile_number'  => 'unique:drivers,mobile_number',
            'phone_number'  => 'unique:drivers,phone_number',
        ]);
        $arr = ['TNDN0'];

        $driver = Driver::orderBy('driver_id', 'desc')->first();

        if ($driver == '' || $driver == null) {
            $driver_id = $arr[array_rand($arr)] . sprintf('%03d', 001);
            $username = 'TNDRIVER0' . sprintf('%03d', 001);
        } else {
            $num = ++$driver->id;
            $driver_id = $arr[array_rand($arr)] . sprintf('%03d', $num);
            $username = 'TNDRIVER0' . sprintf('%03d', $num);
        }
        $file = '';
        if (!empty($request->driver_file)) {
            $imageName = time() . '.' . $request->driver_file->extension();
            $file = $request->driver_file->storeAs('Logistic/Driver', $imageName);
        }
        $data = Driver::insertGetId([
            'username'                  => $username,
            'driver_name'               => $request->driver_name,
            'region'                    => $request->region,
            'postal_code'               => $request->postal_code,
            'address'                   => $request->address,
            'unit_code'                 => $request->unit_code,
            'dob'                       => $request->dob,
            'password'                  => $request->password,
            'mobile_number'             => $request->mobile_number,
            'phone_number'              => $request->phone_number,
            'fax'                       => $request->fax,
            'email'                     => $request->email,
            'vehicle_id'                => $request->vehicle_id,
            'license_plate'             => $request->license_plate,
            'driver_file'               => $file,
            'created_by'                => Auth::user()->id,
            // 'company_id'             =>,
            'created_at'                => now(),
            'updated_at'                => now()
        ]);
        foreach ($request->document_title as $key => $item) {
            $file = '';
            if (!empty($request->document_file[$key])) {
                $imageName = time() . '.' . $request->document_file[$key]->extension();
                $file = $request->document_file[$key]->storeAs('Logistic/Driver', $imageName);
            }
            Driverdocument::create([
                'document_title'           => $item,
                'document_issue_date'      => $request->document_issue_date[$key],
                'document_expiry_date'     => $request->document_expiry_date[$key],
                'document_file'            => $file,
                'driver_id'                => $data,
                'created_by'               => Auth::user()->id,
                // 'company_id
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => "Driver Created Successfully"]);
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
        $data = Driver::where('driver_id', $id)->first();
        $action = route('admin.logistic.update_driver');
        $method = 'post';
        $table  = "driver_list";
        $drivers = Driverdocument::where('driver_id', $id)->get();
        return view('admin.logistic.driver.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
            'drivers'       => $drivers
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }
    public function update_driver(Request $request)
    {
        $request->validate([
            'email'  => [
                '',
                Rule::unique('drivers')->ignore($request->driver_id, 'driver_id')
            ],
            'mobile_number'  => [
                '',
                Rule::unique('drivers')->ignore($request->driver_id, 'driver_id')
            ],
            'phone_number'  => [
                '',
                Rule::unique('drivers')->ignore($request->driver_id, 'driver_id')
            ]
        ]);
        $old_data = Driver::where('driver_id', $request->driver_id)->first();
        $file = '';
        if (!empty($request->driver_file)) {
            $imageName = time() . '.' . $request->driver_file->extension();
            $file = $request->driver_file->storeAs('Logistic/Driver', $imageName);
        } else {
            $file = $old_data->driver_file;
        }
        Driver::where('driver_id', $request->driver_id)->update([
            'driver_name'               => $request->driver_name,
            'region'                    => $request->region,
            'postal_code'               => $request->postal_code,
            'address'                   => $request->address,
            'unit_code'                 => $request->unit_code,
            'dob'                       => $request->dob,
            'password'                  => $request->password,
            'mobile_number'             => $request->mobile_number,
            'phone_number'              => $request->phone_number,
            'fax'                       => $request->fax,
            'email'                     => $request->email,
            'vehicle_id'                => $request->vehicle_id,
            'license_plate'             => $request->license_plate,
            'driver_file'               => $file,
        ]);

        foreach ($request->document_title as $key => $item) {
            $check = Driverdocument::where('driver_document_id', $request->driver_document_id[$key] ?? '')->first();
            Driverdocument::whereNotIn('driver_document_id', $request->driver_document_id)->where('driver_id', $request->driver_id)->delete();
            if ($check) {
                $file = '';
                if (!empty($request->document_file[$key])) {
                    $imageName = time() . '.' . $request->document_file[$key]->extension();
                    $file = $request->document_file[$key]->storeAs('Logistic/Driver', $imageName);
                } else {
                    $file = $check->document_file;
                }
                Driverdocument::where('driver_document_id', $request->driver_document_id[$key])->update([
                    'document_title'           => $item,
                    'document_issue_date'      => $request->document_issue_date[$key],
                    'document_expiry_date'     => $request->document_expiry_date[$key],
                    'document_file'            => $file,
                ]);
            } else {
                $file = '';
                if (!empty($request->document_file[$key])) {
                    $imageName = time() . '.' . $request->document_file[$key]->extension();
                    $file = $request->document_file[$key]->storeAs('Logistic/Driver', $imageName);
                }
                Driverdocument::create([
                    'driver_id'               => $request->driver_id,
                    'document_title'           => $item,
                    'document_issue_date'      => $request->document_issue_date[$key],
                    'document_expiry_date'     => $request->document_expiry_date[$key],
                    'document_file'            => $file,
                    'created_by'               => Auth::user()->id,
                    // 'company_id
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Driver Details Update Successfully"]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Driver::where('driver_id', $id)->delete();
        Driverdocument::where('driver_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Driver Details Delete Successfully"]);
    }
}
