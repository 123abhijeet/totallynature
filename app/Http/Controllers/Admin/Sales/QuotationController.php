<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\PaymentTerms;
use App\Models\PaymentType;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Quotation;
use App\Models\Quotationproduct;
use App\Models\Tax;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function get_product_details()
    {
        $data = Product::join('categories', 'products.category_id', '=', 'categories.category_id')
            ->join('product_price_structures', 'products.product_id', 'product_price_structures.product_id')
            ->where('products.product_id', request()->product_id)
            ->where('product_price_structures.price_structure_id', request()->price_structure)
            ->select('products.product_unique_id as product_unique_id', 'products.product_description as product_description', 'categories.category_name as category_name', 'product_price_structures.price as unit_price')
            ->first();
        return response()->json($data);
    }

    public function get_variant_details()
    {
        $data = ProductVariant::where('product_id', request()->product_id)->get();
        return response()->json($data);
    }
    public function quotation_list()
    {
        $data = Quotation::join('customers', 'customers.customer_id', '=', 'quotations.customer_id')
            ->select('customers.customer_name as customer_name', 'quotations.quotation_id as quotation_id', 'quotations.created_by as created_by', 'quotations.order_date as order_date', 'quotations.quotation_number as quotation_number', 'quotations.net_total as net_total', 'quotations.updated_at as updated_at')
            ->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.sales.quotation.edit', $item->quotation_id);
            $delete = route('admin.sales.quotation.destroy', $item->quotation_id);

            $table = "quotation_list";

            $action = ' <ul class="nav-item dropdown pe-3">
    
                <a class="nav-link nav-action d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                </a>
      
                <ul class="dropdown-menu dropdown-menu-start dropdown-menu-arrow action">
                  <li>
                    <a class="dropdown-item d-flex align-items-center" href="#" onclick="open_edit_modal(`' . $url . '`,`Edit Quotation`)">
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
            $carbonDatetime = Carbon::createFromFormat('Y-m-d H:i:s', $item->updated_at);
            $formattedDatetime = $carbonDatetime->format('Y-m-d h:i:s A');
            $user_details = User::find($item->created_by);
            $new_data[] = array(
                $item->quotation_id,
                $item->quotation_number,
                $item->order_date,
                $item->customer_name,
                $item->net_total,
                $formattedDatetime,
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
    public function index()
    {
        return view('admin.sales.quotation.quotation');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = route('admin.sales.quotation.store');
        $tax = Tax::first();
        $customers = Customer::all();
        $payment_types = PaymentType::all();
        $payment_terms = PaymentTerms::all();
        $products = Product::all();
        $variants = ProductVariant::all();
        $method = 'post';
        $table  = "quotation_list";
        return view('admin.sales.quotation.modal.add_edit')->with([
            'action'        => $action,
            'method'        => $method,
            'customers'     => $customers,
            'products'      => $products,
            'variants'      => $variants,
            'tax'           => $tax,
            'payment_types' => $payment_types,
            'payment_terms' => $payment_terms,
            'table'         => $table
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_id'  => 'required',
            'invoice_address'  => 'required',
            'delivery_address'  => 'required',
            'order_date'  => 'required',
            'tax'  => 'required',
        ]);

        $arr = ['TNSQ0'];

        $quotation = Quotation::orderBy('quotation_id', 'desc')->first();

        if ($quotation == '' || $quotation == null) {
            $quotation_number = $arr[array_rand($arr)] . sprintf('%03d', 001);
        } else {
            $num = ++$quotation->quotation_id;
            $quotation_number = $arr[array_rand($arr)] . sprintf('%03d', $num);
        }
        $data = Quotation::insertGetId([
            'quotation_number' => $quotation_number,
            'customer_id' => $request->customer_id,
            'price_structure' => $request->price_structure,
            'invoice_address' =>  $request->invoice_address,
            'delivery_address' => $request->delivery_address,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'tax' => $request->tax,
            'tax_inclusive' => $request->tax_inclusive != 'on' ? false : true,
            'payment_terms' => $request->payment_terms,
            'payment_type' => $request->payment_type,
            'sales_person' => $request->sales_person,
            'remark' => $request->remark,
            'tandc' => $request->tandc,
            'untaxted_amount' => $request->sub_total,
            'taxes' => $request->gst,
            'net_total' => $request->total_amount,
            'created_by'                => Auth::user()->id,
            // 'company_id'             =>,
            'created_at'                => now(),
            'updated_at'                => now()
        ]);

        foreach ($request->product_id as $key => $item) {
            Quotationproduct::create([
                'quotation_id'         => $data,
                'quotation_number'     => $quotation_number,
                'product_id'           => $item,
                'product_unique_id'    => $request->product_unique_id[$key],
                'description'          => $request->description[$key],
                'category'             => $request->category[$key],
                'quantity'             => $request->quantity[$key],
                'amount'               => $request->gross_amount[$key],
                'variant'              => $request->varriant[$key],
                'unit_price'           => $request->unit_price[$key],
                'convert_so'           => '0',
                'created_by'           => Auth::user()->id,
                // 'company_id
            ]);
        }

        echo json_encode(['status' => 'success', 'message' => "Vehicle Created Successfully"]);
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
        $data = Quotation::where('quotation_id', $id)->first();
        $tax = Tax::first();
        $customers = Customer::all();
        $payment_types = PaymentType::all();
        $payment_terms = PaymentTerms::all();
        $products = Product::all();
        $variants = ProductVariant::all();
        $action = route('admin.sales.update_quotation');
        $method = 'post';
        $table  = "driver_list";
        $quotation_products = Quotationproduct::where('quotation_id', $id)->get();
        return view('admin.sales.quotation.modal.add_edit')->with([
            'action'          => $action,
            'method'          => $method,
            'table'           => $table,
            'data'            => $data,
            'customers'       => $customers,
            'tax'             => $tax,
            'payment_types'   => $payment_types,
            'payment_terms'   => $payment_terms,
            'products'        => $products,
            'variants'        => $variants,
            'quotation_products'       => $quotation_products
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_quotation(Request $request)
    {

        $request->validate([
            'customer_id'  => 'required',
            'invoice_address'  => 'required',
            'delivery_address'  => 'required',
            'order_date'  => 'required',
            'tax'  => 'required',
        ]);

        Quotation::where('quotation_id', $request->quotation_id)->update([
            'customer_id' => $request->customer_id,
            'price_structure' => $request->price_structure,
            'invoice_address' =>  $request->invoice_address,
            'delivery_address' => $request->delivery_address,
            'order_date' => $request->order_date,
            'due_date' => $request->due_date,
            'tax' => $request->tax,
            'tax_inclusive' => $request->tax_inclusive != 'on' ? false : true,
            'payment_terms' => $request->payment_terms,
            'payment_type' => $request->payment_type,
            'sales_person' => $request->sales_person,
            'remark' => $request->remark,
            'tandc' => $request->tandc,
            'untaxted_amount' => $request->sub_total,
            'taxes' => $request->gst,
            'net_total' => $request->total_amount,
            'created_by'                => Auth::user()->id,
            // 'company_id'             =>,
        ]);

        foreach ($request->product_id as $key => $item) {
            $check = Quotationproduct::where('quotation_product_id', $request->quotation_product_id[$key] ?? '')->first();
            Quotationproduct::whereNotIn('quotation_product_id', $request->quotation_product_id)->where('quotation_id', $request->quotation_id)->delete();
            if ($check) {

                Quotationproduct::where('quotation_product_id', $request->quotation_product_id[$key])->update([
                    'product_id'           => $item,
                    'product_unique_id'    => $request->product_unique_id[$key],
                    'description'          => $request->description[$key],
                    'category'             => $request->category[$key],
                    'quantity'             => $request->quantity[$key],
                    'amount'               => $request->gross_amount[$key],
                    'variant'              => $request->varriant[$key],
                    'unit_price'           => $request->unit_price[$key],
                    'convert_so'           => '0',
                    'created_by'           => Auth::user()->id,
                    // 'company_id
                ]);
            } else {

                Quotationproduct::create([
                    'quotation_id'         => $request->quotation_id,
                    'product_id'           => $item,
                    'product_unique_id'    => $request->product_unique_id[$key],
                    'description'          => $request->description[$key],
                    'category'             => $request->category[$key],
                    'quantity'             => $request->quantity[$key],
                    'amount'               => $request->gross_amount[$key],
                    'variant'              => $request->varriant[$key],
                    'unit_price'           => $request->unit_price[$key],
                    'convert_so'           => '0',
                    'created_by'           => Auth::user()->id,
                    // 'company_id
                ]);
            }
        }

        echo json_encode(['status' => 'success', 'message' => "Quotation Updated Created Successfully"]);
    }
    public function update(Request $request, string $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Quotation::where('quotation_id', $id)->delete();
        Quotationproduct::where('quotation_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Quotation Details Deleted Successfully"]);
    }
}
