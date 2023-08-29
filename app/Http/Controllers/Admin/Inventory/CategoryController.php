<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.inventory.category.category');
    }

    function category_list()
    {
        $data = Category::orderBy('category_id', 'desc')->get();
        $new_data = array();
        $action = '';

        foreach ($data as $item) {
            $url = route('admin.inventory.category.edit', $item->category_id);
            $delete = route('admin.inventory.category.destroy', $item->category_id);

            $table = "category_list";

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
                $item->category_id,
                $item->category_name,
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
        $action = route('admin.inventory.category.store');
        $method = 'post';
        $table  = "category_list";
        return view('admin.inventory.category.modal.add_edit')->with([
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
            'category'  => 'required|unique:categories,category_name'
        ]);

        Category::create([
            'category_name'   => $request->category,
            'created_by'      => Auth::user()->id,
            // 'company_id'    =>,
        ]);

        echo json_encode(['status' => 'success', 'message' => "Category Create Successfully"]);
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
        $data = Category::where('category_id', $id)->first();
        $action = route('admin.inventory.update_category');
        $method = 'post';
        $table  = "category_list";

        return view('admin.inventory.category.modal.add_edit')->with([
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

    public function update_category(Request $request)
    {
        $request->validate([
            'category'  => 'required|unique:categories,category_name'
        ]);

        Category::where('category_id', $request->category_id)->update([
            'category_name'   => $request->category,
        ]);

        echo json_encode(['status' => 'success', 'message' => "Category Update Successfully"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Category::where('category_id', $id)->delete();
        echo json_encode(['status' => 'success', 'message' => "Category Delete Successfully"]);
    }
}
