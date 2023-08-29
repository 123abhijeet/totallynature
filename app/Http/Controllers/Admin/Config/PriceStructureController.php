<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\PriceStructure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriceStructureController extends Controller
{
    /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.config.price_structure.price_structure');
  }

  function price_structure_list()
  {
    $data = PriceStructure::orderBy('price_structure_id', 'desc')->get();
    $new_data = array();
    $action = '';

    foreach ($data as $item) {
      $url = route('admin.config.price_structure.edit', $item->price_structure_id);
      $delete = route('admin.config.price_structure.destroy', $item->price_structure_id);

      $table = "price_structure_list";

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
        $item->price_structure_id,
        $item->price_structure,
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
    $action = route('admin.config.price_structure.store');
    $method = 'post';
    $table  = "price_structure_list";
    return view('admin.config.price_structure.modal.add_edit')->with([
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
      'price_structure'  => 'required|unique:price_structures,price_structure'
    ]);

    PriceStructure::create([
      'price_structure'   => $request->price_structure,
      'created_by'      => Auth::user()->id,
      // 'company_id'    =>,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Price Structure Create Successfully"]);
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
    $data = PriceStructure::where('price_structure_id',$id)->first();
    $action = route('admin.config.update_price_structure');
    $method = 'post';
    $table  = "price_structure_list";
    
    return view('admin.config.price_structure.modal.add_edit')->with([
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

  public function update_price_structure(Request $request){
    $request->validate([
        'price_structure'  => 'required|unique:price_structures,price_structure,'.$request->price_structure_id.',price_structure_id'
    ]);

    PriceStructure::where('price_structure_id',$request->price_structure_id)->update([
        'price_structure'   => $request->price_structure,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Price Structure Update Successfully"]);
}

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    PriceStructure::where('price_structure_id',$id)->delete();
    echo json_encode(['status' => 'success', 'message' => "Price Structure Delete Successfully"]);
  }
}
