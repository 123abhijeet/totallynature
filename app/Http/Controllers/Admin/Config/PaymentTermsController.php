<?php

namespace App\Http\Controllers\Admin\Config;

use App\Http\Controllers\Controller;
use App\Models\PaymentTerms;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentTermsController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    return view('admin.config.payment_terms.payment_terms');
  }

  function payment_terms_list()
  {
    $data = PaymentTerms::orderBy('payment_term_id', 'desc')->get();
    $new_data = array();
    $action = '';

    foreach ($data as $item) {
      $url = route('admin.config.payment_terms.edit', $item->payment_term_id);
      $delete = route('admin.config.payment_terms.destroy', $item->payment_term_id);

      $table = "payment_terms_list";

      $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Payment Term`)">
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
        $item->payment_term_id,
        $item->payment_term,
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
    $action = route('admin.config.payment_terms.store');
    $method = 'post';
    $table  = "payment_terms_list";
    return view('admin.config.payment_terms.modal.add_edit')->with([
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
      'payment_term'  => 'required|unique:payment_terms,payment_term'
    ]);

    PaymentTerms::create([
      'payment_term'   => $request->payment_term,
      'created_by'      => Auth::user()->id,
      // 'company_id'    =>,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Payment Term Create Successfully"]);
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
    $data = PaymentTerms::where('payment_term_id',$id)->first();
    $action = route('admin.config.update_payment_term');
    $method = 'post';
    $table  = "payment_terms_list";
    
    return view('admin.config.payment_terms.modal.add_edit')->with([
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

  public function update_payment_term(Request $request){
    $request->validate([
        'payment_term'  => 'required|unique:payment_terms,payment_term,'.$request->payment_term_id.',payment_term_id',
    ]);

    PaymentTerms::where('payment_term_id',$request->payment_term_id)->update([
        'payment_term'   => $request->payment_term,
    ]);

    echo json_encode(['status' => 'success', 'message' => "Payment Term Update Successfully"]);
}

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    PaymentTerms::where('payment_term_id',$id)->delete();
    echo json_encode(['status' => 'success', 'message' => "Payment Term Delete Successfully"]);
  }
}
