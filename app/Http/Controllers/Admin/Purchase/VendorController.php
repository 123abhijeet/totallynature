<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Models\PaymentTerms;
use App\Models\PaymentType;
use App\Models\PriceStructure;
use App\Models\Region;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.purchases.vendor.vendor');
    }

    public function vendor_dropdown(){
        $data = Vendor::orderBy('vendor_id', 'desc')->get();
        echo json_encode($data);
    }


    public function vendor_list()
    {
        $data = Vendor::orderBy('vendor_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.purchase.vendor.edit', $item->vendor_id);
            $delete = route('admin.purchase.vendor.destroy', $item->vendor_id);

            $table = "vendor_list";

            $action = ' <ul class="nav-item dropdown pe-3">

            <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
            </a>
  
            <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
              <li>
                <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit vendor`)">
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
                $item->vendor_id,
                $item->vendor_type,
                $item->vendor_name ?? '--',
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
        $action = route('admin.purchase.vendor.store');
        $method = 'post';
        $table  = "vendor_list";


        $region =  Region::get();
        $payment_term = PaymentTerms::get();
        $payment_type = PaymentType::get();
        $price_structure = PriceStructure::get();

        return view('admin.purchases.vendor.modal.add_edit')->with([
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
        if ($request->vendor_type == 'individual') {
            $request->validate([
                'vendor_type'                        => 'required',
                'individual_vendor_id'               => 'required',
                'individual_file'                      => '',
                'individual_vendor_name'             => 'required',
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
                'vendor_type'                     => 'required',
                'company_vendor_id'               => 'required',
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
            $file = $request->individual_file->storeAs('vendor/individual', $imageName);
        }
        if(!empty($request->company_file)){
            $imageName = time().'.'.$request->company_file->extension();  
            $file = $request->company_file->storeAs('vendor/company', $imageName);
        }


        if ($request->vendor_type == 'individual') {
        vendor::create([
            'vendor_type'         => $request->vendor_type,
            'vendor_image'        => $file,
            'vendor_unique_id'    => $request->individual_vendor_id,
            'vendor_name'         => $request->individual_vendor_name,
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
            'bank_name'             => $request->bank_name,            
            'bank_account_no'     => $request->bank_account_no,

            // 'company_id'            => ''
            'created_by'            => Auth::user()->id
        ]);
    }else{
         vendor::create([
            'vendor_type'         => $request->vendor_type,
            'vendor_image'        => $file,
            'vendor_unique_id'    => $request->company_vendor_id,
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
            'bank_name'             => $request->bank_name,            
            'bank_account_no'     => $request->bank_account_no,
            // 'company_id'            => ''
            'created_by'            => Auth::user()->id
        ]);
    }

        echo json_encode(['status' => 'success', 'message' => "Vendor Create Successfully"]);
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
        $data = vendor::where('vendor_id', $id)->first();
        $action = route('admin.purchase.update_vendor');
        $method = 'post';
        $table  = "vendor_list";

        $region =  Region::get();
        $payment_term = PaymentTerms::get();
        $payment_type = PaymentType::get();
        $price_structure = PriceStructure::get();

        return view('admin.purchases.vendor.modal.add_edit')->with([
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

    public function update_vendor(Request $request)
    {
        if ($request->vendor_type == 'individual') {
            $request->validate([
                'vendor_type'                        => 'required',
                'individual_vendor_id'               => 'required',
                'individual_file'                      => '',
                'individual_vendor_name'             => 'required',
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
                'vendor_type'                       => 'required',
                'company_vendor_id'                 => 'required',
                'company_file'                      => '',
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
            $file = $request->individual_file->storeAs('vendor/individual', $imageName);
        }
        if(!empty($request->company_file)){
            $imageName = time().'.'.$request->company_file->extension();  
            $file = $request->company_file->storeAs('vendor/company', $imageName);
        }



        if ($request->vendor_type == 'individual') {
        vendor::where('vendor_id',$request->vendor_id)->update([
            'vendor_type'         => $request->vendor_type,
            'vendor_image'        => $file,
            'vendor_unique_id'    => $request->individual_vendor_id,
            'vendor_name'         => $request->individual_vendor_name,
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
            'bank_name'             => $request->bank_name,            
            'bank_account_no'       => $request->bank_account_no,

            'company_name'          => '',
            'office_no'             => '',
            'contact_person'        => '',
            'contact_person_no'     => '',
            'website'               => '',    
            // 'company_id'            => ''
        ]);
    }else{
         vendor::where('vendor_id',$request->vendor_id)->update([
            'vendor_type'           => $request->vendor_type,
            'vendor_image'          => $file,
            'vendor_unique_id'      => $request->company_vendor_id,
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
            'bank_name'             => $request->bank_name,            
            'bank_account_no'       => $request->bank_account_no,

            'vendor_name'           => '',
            'contact_number'        => '',
            'whatsapp_no'           => '',

            // 'company_id'            => ''
        ]);
    }

        echo json_encode(['status' => 'success', 'message' => "Vendor Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        vendor::where('vendor_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Vendor Delete Successfully"]);
    }
}
