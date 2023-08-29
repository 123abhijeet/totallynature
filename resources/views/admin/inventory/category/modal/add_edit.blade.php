<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Category Name</label>
        <input type="text" class="form-control" name="category" value="{{ $data->category_name ?? '' }}">
        <input type="hidden" name="category_id" value="{{ $data->category_id ?? '' }}">
    </div>
</form>
