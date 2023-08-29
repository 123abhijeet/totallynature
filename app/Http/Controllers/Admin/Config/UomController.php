<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Uom;
use App\Models\UomCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.config.uom.uom');
    }

    function uom_list()
    {
        $data = UomCategory::orderBy('uom_category_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.config.uom.edit', $item->uom_category_id);
            $delete = route('admin.config.uom.destroy', $item->uom_category_id);

            $table = "uom_list";

            $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Uom`)">
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
                $item->uom_category_id,
                $item->uom_category_name,
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

    public function get_base_uom(){
        $data = Uom::where('uom_category_id',request()->id)->get();
        echo json_encode($data);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.config.uom.store');
        $method = 'post';
        $table  = "uom_list";
        return view('admin.config.uom.modal.add_edit')->with([
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
            'uom_category_name'  => 'required|unique:uom_categories,uom_category_name'
        ]);

        $data = UomCategory::insertGetId([
            'uom_category_name'     => $request->uom_category_name,
            'created_by'            => Auth::user()->id,
            // 'company_id'    =>,
            'created_at'            => now(),
            'updated_at'            => now()
        ]);

        foreach ($request->unit_of_measure as $key => $item) {
            Uom::create([
                'uom'               => $item,
                'ratio'             => $request->ratio[$key],
                'uom_category_id'   => $data,
                'created_by'        => Auth::user()->id,
                // 'company_id
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => "Uom Create Successfully"]);
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
        $data = UomCategory::where('uom_category_id', $id)->first();
        $action = route('admin.config.update_uom');
        $method = 'post';
        $table  = "uom_list";
        $uom = Uom::where('uom_category_id', $id)->get();

        return view('admin.config.uom.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
            'uom'       => $uom
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_uom(Request $request)
    {
        $request->validate([
            'uom_category_name'  => [
                'required',
                Rule::unique('uom_categories')->ignore($request->uom_category_id, 'uom_category_id')
            ]
        ]);

        UomCategory::where('uom_category_id', $request->uom_category_id)->update([
            'uom_category_name'     => $request->uom_category_name,
        ]);

        foreach ($request->unit_of_measure as $key => $item) {
            $check = Uom::where('uom_id', $request->unit_of_measure_id[$key] ?? '')->first();
            Uom::whereNotIn('uom_id', $request->unit_of_measure_id)->where('uom_category_id',$request->uom_category_id)->delete();
            if ($check) {
                Uom::where('uom_id', $request->unit_of_measure_id[$key])->update([
                    'uom'               => $item,
                    'ratio'             => $request->ratio[$key],
                    'uom_category_id'   => $request->uom_category_id,
                    'created_by'        => Auth::user()->id,
                    // 'company_id
                ]);
            } else {
                Uom::create([
                    'uom'               => $item,
                    'ratio'             => $request->ratio[$key],
                    'uom_category_id'   => $request->uom_category_id,
                    'created_by'        => Auth::user()->id,
                    // 'company_id
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Uom Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        UomCategory::where('uom_category_id', $id)->delete();
        Uom::where('uom_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Uom Delete Successfully"]);
    }
}
