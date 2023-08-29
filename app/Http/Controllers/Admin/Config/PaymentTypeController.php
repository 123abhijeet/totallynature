<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\PaymentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentTypeController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.config.payment_type.payment_type');
  }

  function payment_type_list()
  {
    $data = PaymentType::orderBy('payment_type_id', 'desc')->get();
    $new_data = array();
    $action = '';

    foreach ($data as $item) {
      $url = route('admin.config.payment_type.edit', $item->payment_type_id);
      $delete = route('admin.config.payment_type.destroy', $item->payment_type_id);

      $table = "payment_type_list";

      $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Payment Type`)">
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
        $item->payment_type_id,
        $item->payment_type,
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
    $action = route('admin.config.payment_type.store');
    $method = 'post';
    $table  = "payment_type_list";
    return view('admin.config.payment_type.modal.add_edit')->with([
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
      'payment_type'  => 'required|unique:payment_types,payment_type'
    ]);

    PaymentType::create([
      'payment_type'   => $request->payment_type,
      'created_by'      => Auth::user()->id,
      // 'company_id'    =>,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Payment type Create Successfully"]);
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
    $data = PaymentType::where('payment_type_id',$id)->first();
    $action = route('admin.config.update_payment_type');
    $method = 'post';
    $table  = "payment_type_list";
    
    return view('admin.config.payment_type.modal.add_edit')->with([
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

  public function update_payment_type(Request $request){
    $request->validate([
        'payment_type'  => 'required|unique:payment_types,payment_type,'.$request->payment_type_id.',payment_type_id'
    ]);

    PaymentType::where('payment_type_id',$request->payment_type_id)->update([
        'payment_type'   => $request->payment_type,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Payment type Update Successfully"]);
}

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    PaymentType::where('payment_type_id',$id)->delete();
    echo json_encode(['status' => 'success', 'message' => "Payment type Delete Successfully"]);
  }
}
