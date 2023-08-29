<?php

namespace App\Http\Controllers\Admin\Fleet;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DailylogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function dailylog_list()
    {
        if(request()->from == null && request()->to == null){

            $data = Service::join('drivers', 'drivers.driver_id', '=', 'services.driver_id')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'services.vehicle_id')
            ->orderBy('services.service_id', 'desc')
            ->get(["services.*", "drivers.driver_name as driver_name_is", "vehicles.vehicle_modal as vehicle_modal_is"]);
        }
        elseif(request()->from !=null && request()->to == null)
        {

            $data = Service::join('drivers', 'drivers.driver_id', '=', 'services.driver_id')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'services.vehicle_id')
            ->whereDate('date', '>=', request()->from)
            ->orderBy('services.service_id', 'desc')
            ->get(["services.*", "drivers.driver_name as driver_name_is", "vehicles.vehicle_modal as vehicle_modal_is"]);

        }
        elseif(request()->from ==null && request()->to != null)
        {
            $data = Service::join('drivers', 'drivers.driver_id', '=', 'services.driver_id')
            ->join('vehicles', 'vehicles.vehicle_id', '=', 'services.vehicle_id')
            ->whereDate('date', '<=', request()->to)
            ->orderBy('services.service_id', 'desc')
            ->get(["services.*", "drivers.driver_name as driver_name_is", "vehicles.vehicle_modal as vehicle_modal_is"]);
        }
        else
        {
            $query = 'SELECT services.*,drivers.driver_name as driver_name_is,vehicles.vehicle_modal as vehicle_modal_is FROM services join drivers on drivers.driver_id=services.driver_id join vehicles on vehicles.vehicle_id=services.vehicle_id WHERE STR_TO_DATE(services.date,"%d-%m-%Y") BETWEEN STR_TO_DATE("'.request()->from.'","%d-%m-%Y") AND STR_TO_DATE("'.request()->to.'","%d-%m-%Y")';

            $data = DB::select($query);
        }
        $new_data = array();
        $i = 0;

        foreach ($data as $item) {

            $user_details = User::find($item->created_by);
            $new_data[] = array(
                ++$i,
                $item->vehicle_modal_is,
                $item->service_type,
                $item->description,
                $item->cost,
                $user_details->name,
            );
        }
        $output = array(
            "draw"                 => request()->draw,
            // "recordsTotal"         => $data->count(),
            // "recordsFiltered"     => $data->count(),
            "data"                 => $new_data
        );
        echo json_encode($output);
    }
    public function index()
    {
        return view('admin.fleet.dailylog.dailylog');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
