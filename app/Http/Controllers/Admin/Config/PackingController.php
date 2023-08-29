<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\Packing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PackingController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.config.packing.packing');
  }

  public function packing_dropdown()
  {
    $data = Packing::orderBy('packing_id', 'desc')->get();
    echo json_encode($data);
  }

  function packing_list()
  {
    $data = Packing::orderBy('packing_id', 'desc')->get();
    $new_data = array();
    $action = '';

    foreach ($data as $item) {
      $url = route('admin.config.packing.edit', $item->packing_id);
      $delete = route('admin.config.packing.destroy', $item->packing_id);

      $table = "packing_list";

      $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Price Structure`)">
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
        $item->packing_id,
        $item->packing_name,
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
   * Show the form for creating a new resource.
   */
  public function create()
  {
    $action = route('admin.config.packing.store');
    $method = 'post';
    $table  = "packing_list";
    return view('admin.config.packing.modal.add_edit')->with([
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
      'packing'  => 'required|unique:packings,packing_name'
    ]);

    Packing::create([
      'packing_name'   => $request->packing,
      'created_by'      => Auth::user()->id,
      // 'company_id'    =>,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Product Type Create Successfully"]);
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
    $data = Packing::where('packing_id', $id)->first();
    $action = route('admin.config.update_packing');
    $method = 'post';
    $table  = "packing_list";

    return view('admin.config.packing.modal.add_edit')->with([
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
    //
  }

  public function update_packing(Request $request)
  {
    $request->validate([
      'packing'  => 'required|unique:packings,packing_name,' . $request->packing_id . ',packing_id'
    ]);

    Packing::where('packing_id', $request->packing_id)->update([
      'packing_name'   => $request->packing,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Packing Update Successfully"]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    Packing::where('packing_id', $id)->delete();
    echo json_encode(['status' => 'success', 'message' => "Packing Delete Successfully"]);
  }
}
