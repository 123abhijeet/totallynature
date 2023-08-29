<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.config.region.region');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.config.region.store');
        $method = 'post';
        $table  = "region_list";
        return view('admin.config.region.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table
        ]);
    }

    public function region_list()
    {
        $data = Region::orderBy('region_id','desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.config.region.edit',$item->region_id);
            $delete = route('admin.config.region.destroy',$item->region_id);

            $table = "region_list";

            $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`'.$url.'`,`Edit Region`)">
                <i class="bi bi-pencil-square"></i>
                  <span>Edit</span>
                </a>
              </li>
              <li>
                <hr class="dropdown-divider">
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="delete_modal(`'.$delete.'`,`'.$table.'`)">
                <i class="bi bi-trash3"></i>
                  <span>Delete</span>
                </a>
              </li>
            </ul>
          </ul>';
                $user_details = User::find($item->created_by);
            $new_data[] = array(
                $item->region_id,
                $item->region_name,
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


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'region'  => 'required|unique:regions,region_name'
        ]);

        Region::create([
            'region_name'   => $request->region,
            'created_by'    => Auth::user()->id,
            // 'company_id'    =>,
        ]);

        echo json_encode(['status' => 'success', 'message' => "Region Create Successfully"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo 1;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Region::where('region_id',$id)->first();
        $action = route('admin.config.update_region');
        $method = 'post';
        $table  = "region_list";
        return view('admin.config.region.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    public function update_region(Request $request){
        $request->validate([
            'region'  => 'required|unique:regions,region_name,'.$request->region_id.',region_id'
        ]);

        Region::where('region_id',$request->region_id)->update([
            'region_name'   => $request->region,
        ]);

        echo json_encode(['status' => 'success', 'message' => "Region Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // echo json_encode($id);
        Region::where('region_id',$id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Region Delete Successfully"]);
    }
}
