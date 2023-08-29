<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Packing;
use App\Models\PriceStructure;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductPriceStructure;
use App\Models\ProductType;
use App\Models\ProductVariant;
use App\Models\Uom;
use App\Models\UomCategory;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory.products.product');
    }

    function product_list()
    {
        $data = Product::orderBy('product_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.inventory.product.edit', $item->product_id);
            $delete = route('admin.inventory.product.destroy', $item->product_id);

            $table = "product_list";

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
            $product_type = ProductType::where('product_type_id',$item->product_type_id)->first();
            $category = Category::where('category_id',$item->category_id)->first();
            $new_data[] = array(
                $item->product_id,
                $item->product_name,
                $item->product_unique_id,
                $product_type->product_type,
                $item->internal_reference,
                $category->category_name,
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
        $action = route('admin.inventory.product.store');
        $method = 'post';
        $table  = "product_list";

        $price_structure    = PriceStructure::get();
        $product_type       = ProductType::get();
        $category           = Category::get();
        $uom_category       = UomCategory::get();
        $uom                = Uom::get();
        $warehouse          = Warehouse::get();

        return view('admin.inventory.products.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'price_structure' => $price_structure,
            'product_type'  => $product_type,
            'category'      => $category,
            'uom_category'  => $uom_category,
            'uom'           => $uom,
            'warehouse'     => $warehouse
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_name'          => 'required|unique:products,product_name',
            'product_unique_id'            => 'required|unique:products,product_name',
            'product_type'          => 'required',
            'internal_reference'    => 'required',
            'category'              => 'required',
            'description'           => '',
            'category'              => 'required',
            'base_uom'     => 'required',
            'warehouse'             => '',
            'warehouse_sub_location' => '',
            'safety_stock'          => 'required',
            'notification_for_expiry' => 'required',
            'hs_code'               => ''
        ]);

        $file = '';
        if(!empty($request->individual_file)){
            $imageName = time().'.'.$request->individual_file->extension();  
            $file = $request->individual_file->storeAs('product', $imageName);
        }

        $product = Product::insertGetId([
            'for_sale'              => $request->for_sale ? 1 : 0,
            'for_internal_use'      => $request->for_sale ? 1 : 0,
            'foc_sample'            => $request->foc_sample ? 1 : 0,
            'product_image'         => $file,
            'product_name'          => $request->product_name,
            'product_unique_id'     => $request->product_unique_id,
            'product_type_id'           => $request->product_type,
            'internal_reference'        => $request->internal_reference,
            'category_id'               => $request->category,
            'product_description'       => $request->description,
            'uom_category_id'           => $request->category,
            'uom_measure_id'            => $request->base_uom,
            'warehouse_id'              => $request->warehouse,
            'warehouse_sub_location_id' => $request->warehouse_sub_location,
            'safety_stock'              => $request->safety_stock,
            'notification_for_expiry'   => $request->notification_for_expiry,
            'hs_code'                   => $request->hs_code,
            'created_by'                => Auth::user()->id
            // 'company_id'    =>,
        ]);

       

        if(!empty($request->vendor)){
            foreach ($request->vendor as $key => $item) {
                ProductInventory::create([
                    'vendor_id'     => $item,
                    'price'         => $request->price[$key],
                    'product_id'    => $product    
                ]);
            }
        }

        if(!empty($request->qnt)){
            foreach ($request->qnt as $key => $item) {
                ProductVariant::create([
                    'qnt'               => $item,
                    'uom_measure_id'    => $request->uom_measure_id[$key],
                    'product_id'        => $product,
                    'packaging_id'      => $request->packaging[$key]
                ]);
            }
        }


        if(!empty($request->price_structure_id)){
            foreach ($request->price_structure_id as $key => $item) {
                ProductPriceStructure::create([
                    'product_id'            => $product,
                    'price_structure_id'    => $item,
                    'price'                 => $request->price_structure[$key],
                ]);
            }
        }




        echo json_encode(['status' => 'success', 'message' => "product Create Successfully"]);
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
        $data = product::where('product_id', $id)->first();
        $action = route('admin.inventory.update_product');
        $method = 'post';
        $table  = "product_list";


        $price_structure    = PriceStructure::get();
        $product_type       = ProductType::get();
        $category           = Category::get();
        $uom_category       = UomCategory::get();
        $uom                = Uom::get();
        $warehouse          = Warehouse::get();

        $product_vendor             = ProductInventory::where('product_id',$id)->get(); 
        $product_variants           = ProductVariant::where('product_id',$id)->get(); 
        $product_price_structure    = ProductPriceStructure::where('product_id',$id)->get(); 

        return view('admin.inventory.products.modal.add_edit')->with([
            'action'    => $action,
            'method'    => $method,
            'table'     => $table,
            'data'      => $data,
            'vendor'    => Vendor::get(),
            'uom_select'       => Uom::where('uom_category_id',$data->uom_category_id)->get(),   
            'packaging'         => Packing::get(),

            'price_structure'   => $price_structure,
            'product_type'      => $product_type,
            'category'          => $category,
            'uom_category'      => $uom_category,
            'uom'               => $uom,
            'warehouse'         => $warehouse,
            'product_vendor'            => $product_vendor,
            'product_variants'          => $product_variants,
            'product_price_structure'   => $product_price_structure

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function update_product(Request $request)
    {
        $request->validate([
            'product'  => 'required|unique:categories,product_name'
        ]);

        product::where('product_id', $request->product_id)->update([
            'product_name'   => $request->product,
        ]);

        echo json_encode(['status' => 'success', 'message' => "Product Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::where('product_id', $id)->delete();
        ProductVariant::where('product_id', $id)->delete();
        ProductInventory::where('product_id', $id)->delete();
        ProductPriceStructure::where('product_id', $id)->delete();
        
        echo json_encode(['status' => 'success', 'message' => "Product Delete Successfully"]);
    }
}
