<?php

use App\Http\Controllers\Admin\Config\PackingController;
use App\Http\Controllers\Admin\Config\PaymentTermsController;
use App\Http\Controllers\Admin\Config\PaymentTypeController;
use App\Http\Controllers\Admin\Config\PriceStructureController;
use App\Http\Controllers\Admin\Config\ProductTypeController;
use App\Http\Controllers\Admin\Config\RegionController;
use App\Http\Controllers\Admin\Config\TaxController;
use App\Http\Controllers\Admin\Config\UomController;
use App\Http\Controllers\Admin\Config\WarehouseController;
use App\Http\Controllers\Admin\Inventory\CategoryController;
use App\Http\Controllers\Admin\Purchase\VendorController;
use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\Sales\CustomerController;
use App\Http\Controllers\Admin\Fleet\DailylogController;
use App\Http\Controllers\Admin\Fleet\FleettrackingController;
use App\Http\Controllers\Admin\Fleet\VehicleController;
use App\Http\Controllers\Admin\Fleet\ServiceController;
use App\Http\Controllers\Admin\Inventory\ProductController;
use App\Http\Controllers\Admin\Logistic\DriverController;
use App\Http\Controllers\Admin\Sales\QuotationController;
use App\Http\Controllers\ProfileController;
use App\Models\Quotation;
use Illuminate\Support\Facades\Route;
use GuzzleHttp\Client;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return view('admin.Dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {

    // sales module
    Route::prefix('sales')->name('sales.')->group(function () {

        // customer
        Route::post('update_customer', [CustomerController::class, 'update_customer'])->name('update_customer');
        Route::get('customer_list', [CustomerController::class, 'customer_list'])->name('customer_list');
        Route::resource('customers', CustomerController::class);

        // end customer

        // quotation
        Route::get('get_product_details',[QuotationController::class,'get_product_details'])->name('get_product_details');
        Route::get('get_variant_details',[QuotationController::class,'get_variant_details'])->name('get_variant_details');
        Route::post('update_quotation', [QuotationController::class, 'update_quotation'])->name('update_quotation');
        Route::get('quotation_list', [QuotationController::class, 'quotation_list'])->name('quotation_list');
        Route::resource('quotation', QuotationController::class);

        // end quotation

    });
    // end sales module

    // inventory
    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::post('update_category', [CategoryController::class, 'update_category'])->name('update_category');
        Route::get('category_list', [CategoryController::class, 'category_list'])->name('category_list');
        Route::resource('category', CategoryController::class);



        Route::post('update_product', [ProductController::class, 'update_product'])->name('update_product');
        Route::get('product_list', [ProductController::class, 'product_list'])->name('product_list');
        Route::resource('product', ProductController::class);
    });
    // end inventory

    // purchases module
    Route::prefix('purchase')->name('purchase.')->group(function () {
        Route::get('vendor_dropdown', [VendorController::class, 'vendor_dropdown'])->name('vendor_dropdown');
        Route::post('update_vendor', [VendorController::class, 'update_vendor'])->name('update_vendor');
        Route::get('vendor_list', [VendorController::class, 'vendor_list'])->name('vendor_list');
        Route::resource('vendor', VendorController::class);
    });
    // end purchases module


    // config module
    Route::prefix('config')->name('config.')->group(function () {

        // roles
        Route::resource('roles', RolesController::class);
        // end roles



        // Region module
        Route::post('update_region', [RegionController::class, 'update_region'])->name('update_region');
        Route::get('region_list', [RegionController::class, 'region_list'])->name('region_list');
        Route::resource('region', RegionController::class);
        // end region module

        // payment terms module
        Route::post('update_payment_term', [PaymentTermsController::class, 'update_payment_term'])->name('update_payment_term');
        Route::get('payment_terms_list', [PaymentTermsController::class, 'payment_terms_list'])->name('payment_terms_list');
        Route::resource('payment_terms', PaymentTermsController::class);
        // end payment terms module

        // payment type module
        Route::post('update_payment_type', [PaymentTypeController::class, 'update_payment_type'])->name('update_payment_type');
        Route::get('payment_type_list', [PaymentTypeController::class, 'payment_type_list'])->name('payment_type_list');
        Route::resource('payment_type', PaymentTypeController::class);
        // end payment type module

        // Price Structure module
        Route::post('update_price_structure', [PriceStructureController::class, 'update_price_structure'])->name('update_price_structure');
        Route::get('price_structure_list', [PriceStructureController::class, 'price_structure_list'])->name('price_structure_list');
        Route::resource('price_structure', PriceStructureController::class);
        // end Price Structure module

        // product type module
        Route::post('update_product_type', [ProductTypeController::class, 'update_product_type'])->name('update_product_type');
        Route::get('product_type_list', [ProductTypeController::class, 'product_type_list'])->name('product_type_list');
        Route::resource('product_type', ProductTypeController::class);
        // end product type module

        // uom  module
        Route::get('get_base_uom', [UomController::class, 'get_base_uom'])->name('get_base_uom');
        Route::post('update_uom', [UomController::class, 'update_uom'])->name('update_uom');
        Route::get('uom_list', [UomController::class, 'uom_list'])->name('uom_list');
        Route::resource('uom', UomController::class);
        // end uom module

        // tax  module
        Route::post('update_tax', [TaxController::class, 'update_tax'])->name('update_tax');
        Route::get('tax_list', [TaxController::class, 'tax_list'])->name('tax_list');
        Route::resource('tax', TaxController::class);
        // end tax module

        // warehouse  module
        Route::get('warehouse_sub_location_list', [WarehouseController::class, 'warehouse_sub_location_list'])->name('warehouse_sub_location_list');
        Route::post('update_warehouse', [WarehouseController::class, 'update_warehouse'])->name('update_warehouse');
        Route::get('warehouse_list', [WarehouseController::class, 'warehouse_list'])->name('warehouse_list');
        Route::resource('warehouse', WarehouseController::class);
        // end warehouse module

        // warehouse  module
        Route::get('packing_dropdown', [PackingController::class, 'packing_dropdown'])->name('packing_dropdown');
        Route::post('update_packing', [PackingController::class, 'update_packing'])->name('update_packing');
        Route::get('packing_list', [PackingController::class, 'packing_list'])->name('packing_list');
        Route::resource('packing', PackingController::class);
        // end warehouse module


    });
    // end config module

    // logistic module
    Route::prefix('logistic')->name('logistic.')->group(function () {

        // driver module
        Route::post('update_driver', [DriverController::class, 'update_driver'])->name('update_driver');
        Route::get('driver_list', [DriverController::class, 'driver_list'])->name('driver_list');
        Route::resource('driver', DriverController::class);
        // end driver module

    });
    // end logistic module

    // fleet module
    Route::prefix('fleet')->name('fleet.')->group(function () {

        // Dashboard
        Route::get('expired_documents', [VehicleController::class, 'expired_documents'])->name('expired_documents');
        Route::get('expired_document_list', [VehicleController::class, 'expired_document_list'])->name('expired_document_list');

        // vehicle module
        Route::post('update_vehicle', [VehicleController::class, 'update_vehicle'])->name('update_vehicle');
        Route::get('vehicle_list', [VehicleController::class, 'vehicle_list'])->name('vehicle_list');
        Route::resource('vehicle', VehicleController::class);
        // end vehicle module

        // service module
        Route::post('update_service', [ServiceController::class, 'update_service'])->name('update_service');
        Route::get('service_list', [ServiceController::class, 'service_list'])->name('service_list');
        Route::resource('service', ServiceController::class);
        // end service module

        // dailylog module
        Route::get('dailylog_list', [DailylogController::class, 'dailylog_list'])->name('dailylog_list');
        Route::resource('dailylog', DailylogController::class);
        // end dailylog module

        // fleettracking module
        Route::resource('fleettracking', FleettrackingController::class);
        // end fleettracking module


    });
    // end fleet module





    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// GET ADDRESS USING API
Route::get('/address/api', function () {
    $address = new Client();
    $res =  $address->request('GET', 'https://developers.onemap.sg/commonapi/search?searchVal=' . request()->postalcode . '&returnGeom=Y&getAddrDetails=Y', [
        'headers' => [
            'Content-Type' => 'application/json',
            'cache' => false,
            'Accept'     => 'application/json',
        ],
    ]);
    return ($res->getBody());
})->name('user.apiAddress');

Route::get('/getlicense_plate',[DriverController::class,'getlicense_plate'])->name('getlicense_plate');

require __DIR__ . '/auth.php';
