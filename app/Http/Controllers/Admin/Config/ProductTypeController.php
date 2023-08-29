<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.config.product_type.product_type');
  }

  function product_type_list()
  {
    $data = ProductType::orderBy('product_type_id', 'desc')->get();
    $new_data = array();
    $action = '';

    foreach ($data as $item) {
      $url = route('admin.config.product_type.edit', $item->product_type_id);
      $delete = route('admin.config.product_type.destroy', $item->product_type_id);

      $table = "product_type_list";

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
        $item->product_type_id,
        $item->product_type,
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
    $action = route('admin.config.product_type.store');
    $method = 'post';
    $table  = "product_type_list";
    return view('admin.config.product_type.modal.add_edit')->with([
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
      'product_type'  => 'required|unique:product_types,product_type'
    ]);

    ProductType::create([
      'product_type'   => $request->product_type,
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
    $data = ProductType::where('product_type_id', $id)->first();
    $action = route('admin.config.update_product_type');
    $method = 'post';
    $table  = "product_type_list";

    return view('admin.config.product_type.modal.add_edit')->with([
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

  public function update_product_type(Request $request)
  {
    $request->validate([
      'product_type'  => 'required|unique:product_types,product_type,' . $request->product_type_id . ',product_type_id'
    ]);

    ProductType::where('product_type_id', $request->product_type_id)->update([
      'product_type'   => $request->product_type,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Product Type Update Successfully"]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    ProductType::where('product_type_id', $id)->delete();
    echo json_encode(['status' => 'success', 'message' => "Product Type Delete Successfully"]);
  }
}
