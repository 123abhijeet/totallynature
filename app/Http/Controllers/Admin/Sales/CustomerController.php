<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PaymentTerms;
use App\Models\PaymentType;
use App\Models\PriceStructure;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.sales.customer.customer_list');
    }

    public function customer_list()
    {
        $data = Customer::orderBy('customer_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.sales.customers.edit', $item->customer_id);
            $delete = route('admin.sales.customers.destroy', $item->customer_id);

            $table = "customer_list";

            $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Customer`)">
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
                $item->customer_id,
                $item->customer_type,
                $item->customer_name ?? '--',
                $item->contact_number ?? '--',
                $item->company_name ?? '--',
                $item->contact_person ?? '--',
                $item->contact_person_no ?? '--',
                $item->whatsapp_no ?? '--',
                $item->email_id ?? '--',
                $item->address ?? '--',

                $item->region ?? '--',
                $item->payment_terms ?? '--',
                $item->payment_type ?? '--',
                $item->credit_limit ?? '--',
                $item->price_structure ?? '--',
                $item->website ?? '--',
                $user_details->name ?? '--',
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
        $action = route('admin.sales.customers.store');
        $method = 'post';
        $table  = "customer_list";


        $region =  Region::get();
        $payment_term = PaymentTerms::get();
        $payment_type = PaymentType::get();
        $price_structure = PriceStructure::get();

        return view('admin.sales.customer.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,

            'region'    => $region,
            'payment_term' => $payment_term,
            'payment_type'  => $payment_type,
            'price_structure'   => $price_structure
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->customer_type == 'individual') {
            $request->validate([
                'customer_type'                        => 'required',
                'individual_customer_id'               => 'required',
                'individual_file'                      => '',
                'individual_customer_name'             => 'required',
                'individual_contact_number'            => 'required|numeric',
                'individual_whatsapp_no'               => 'numeric',
                'individual_email_id'                  => !empty($request->individual_email_id) ? 'required|email' : '',
                'individual_postal_code'               => 'required|numeric',
                'individual_address'                   => 'required',
                'individual_unit_number'               => 'required',
                'individual_region'                    => 'required',
                'individual_payment_terms'             => 'required',
                'individual_payment_type'              => 'required',
                'individual_credit_limit'              => '',
                'individual_price_structure'           => 'required',
            ]);
        } else {
            $request->validate([
                'customer_type'                     => 'required',
                'company_customer_id'               => 'required',
                'company_file'                      => 'required',
                'company_postal_code'               => 'required|numeric',
                'company_address'                   => 'required',
                'company_unit_number'               => 'required',
                'company_region'                    => 'required',
                'company_office_no'                 => 'required',
                'company_contact_person'            => 'required',
                'company_contact_person_no'         => 'required|numeric',
                'company_email_id'                  => !empty($request->company_email_id) ? 'required|email' : '',
                'company_website'                   => '',
                'company_payment_terms'             => 'required',
                'company_payment_type'              => 'required',
                'company_credit_limit'              => '',
                'company_price_structure'           => 'required',
            ]);
        }

        $file = '';
        if(!empty($request->individual_file)){
            $imageName = time().'.'.$request->individual_file->extension();  
            $file = $request->individual_file->storeAs('customer/individual', $imageName);
        }
        if(!empty($request->company_file)){
            $imageName = time().'.'.$request->company_file->extension();  
            $file = $request->company_file->storeAs('customer/company', $imageName);
        }


        if ($request->customer_type == 'individual') {
        Customer::create([
            'customer_type'         => $request->customer_type,
            'customer_image'        => $file,
            'customer_unique_id'    => $request->individual_customer_id,
            'customer_name'         => $request->individual_customer_name,
            'contact_number'        => $request->individual_contact_number,
            'whatsapp_no'           => $request->individual_whatsapp_no,
            'email_id'              => $request->individual_email_id,
            'postal_code'           => $request->individual_postal_code,
            'address'               => $request->individual_address,
            'unit_number'           => $request->individual_unit_number,
            'region'                => $request->individual_region,
            'payment_terms'         => $request->individual_payment_terms,
            'payment_type'          => $request->individual_payment_type,
            'credit_limit'          => $request->individual_credit_limit,
            'price_structure'       => $request->individual_price_structure,
            // 'company_id'            => ''
            'created_by'            => Auth::user()->id
        ]);
    }else{
         Customer::create([
            'customer_type'         => $request->customer_type,
            'customer_image'        => $file,
            'customer_unique_id'    => $request->company_customer_id,
            'company_name'          => $request->company_company_name,
            'email_id'              => $request->company_email_id,
            'postal_code'           => $request->company_postal_code,
            'address'               => $request->company_address,
            'unit_number'           => $request->company_unit_number,
            'region'                => $request->company_region,
            'office_no'             => $request->company_office_no,
            'contact_person'        => $request->company_contact_person,
            'contact_person_no'     => $request->company_contact_person_no,
            'payment_terms'         => $request->company_payment_terms,
            'payment_type'          => $request->company_payment_type,
            'credit_limit'          => $request->company_credit_limit,
            'website'               => $request->company_website,    
            'price_structure'       => $request->company_price_structure,
            // 'company_id'            => ''
            'created_by'            => Auth::user()->id
        ]);
    }

        echo json_encode(['status' => 'success', 'message' => "Customer Create Successfully"]);
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
        $data = Customer::where('customer_id', $id)->first();
        $action = route('admin.sales.update_customer');
        $method = 'post';
        $table  = "customer_list";

        $region =  Region::get();
        $payment_term = PaymentTerms::get();
        $payment_type = PaymentType::get();
        $price_structure = PriceStructure::get();

        return view('admin.sales.customer.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,

            'region'            => $region,
            'payment_term'      => $payment_term,
            'payment_type'      => $payment_type,
            'price_structure'   => $price_structure
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_customer(Request $request)
    {
        if ($request->customer_type == 'individual') {
            $request->validate([
                'customer_type'                        => 'required',
                'individual_customer_id'               => 'required',
                'individual_customer_image'            => '',
                'individual_customer_name'             => 'required',
                'individual_contact_number'            => 'required',
                'individual_whatsapp_no'               => '',
                'individual_email_id'                  => '',
                'individual_postal_code'               => 'required',
                'individual_address'                   => 'required',
                'individual_unit_number'               => 'required',
                'individual_region'                    => 'required',
                'individual_payment_terms'             => 'required',
                'individual_payment_type'              => 'required',
                'individual_credit_limit'              => '',
                'individual_price_structure'           => 'required',
            ]);
        } else {
            $request->validate([
                'customer_type'                     => 'required',
                'company_customer_id'               => 'required',
                'company_company_name'              => 'required',
                'company_postal_code'               => 'required',
                'company_address'                   => 'required',
                'company_unit_number'               => 'required',
                'company_region'                    => 'required',
                'company_office_no'                 => 'required',
                'company_contact_person'            => 'required',
                'company_contact_person_no'         => 'required',
                'company_website'                   => '',
                'company_payment_terms'             => 'required',
                'company_payment_type'              => 'required',
                'company_credit_limit'              => '',
                'company_price_structure'           => 'required',
            ]);
        }
        if ($request->customer_type == 'individual') {
        Customer::where('customer_id',$request->customer_id)->update([
            'customer_type'         => $request->customer_type,
            'customer_image'        => $request->customer_type,
            'customer_unique_id'    => $request->individual_customer_id,
            'customer_name'         => $request->individual_customer_name,
            'contact_number'        => $request->individual_contact_number,
            'whatsapp_no'           => $request->individual_whatsapp_no,
            'email_id'              => $request->individual_email_id,
            'postal_code'           => $request->individual_postal_code,
            'address'               => $request->individual_address,
            'unit_number'           => $request->individual_unit_number,
            'region'                => $request->individual_region,
            'payment_terms'         => $request->individual_payment_terms,
            'payment_type'          => $request->individual_payment_type,
            'credit_limit'          => $request->individual_credit_limit,
            'price_structure'       => $request->individual_price_structure,

            'company_name'          => '',
            'office_no'             => '',
            'contact_person'        => '',
            'contact_person_no'     => '',
            'website'               => '',    
            // 'company_id'            => ''
        ]);
    }else{
         Customer::where('customer_id',$request->customer_id)->update([
            'customer_type'         => $request->customer_type,
            'customer_image'        => $request->customer_type,
            'customer_unique_id'    => $request->company_customer_id,
            'company_name'          => $request->company_company_name,
            'email_id'              => $request->company_email_id,
            'postal_code'           => $request->company_postal_code,
            'address'               => $request->company_address,
            'unit_number'           => $request->company_unit_number,
            'region'                => $request->company_region,
            'office_no'             => $request->company_office_no,
            'contact_person'        => $request->company_contact_person,
            'contact_person_no'     => $request->company_contact_person_no,
            'payment_terms'         => $request->company_payment_terms,
            'payment_type'          => $request->company_payment_type,
            'credit_limit'          => $request->company_credit_limit,
            'website'               => $request->company_website,    
            'price_structure'       => $request->company_price_structure,

            'customer_name'         => '',
            'contact_number'        => '',
            'whatsapp_no'           => '',

            // 'company_id'            => ''
        ]);
    }

        echo json_encode(['status' => 'success', 'message' => "Customer Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Customer::where('customer_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Customer Delete Successfully"]);
    }
}
