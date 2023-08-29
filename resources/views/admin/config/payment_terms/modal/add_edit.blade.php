<form class="row g-3"  action="{{ $action }}" id="add_resion_form" method="{{ $method }}" data-table="{{ $table }}"> 
    @csrf
    @method($method)
    <div class="col-12">
        <label for="inputNanme4" class="form-label">Payment Term</label>
        <input type="text" class="form-control" name="payment_term" value="{{ $data->payment_term ?? '' }}">
        <input type="hidden" name="payment_term_id" value="{{ $data->payment_term_id ?? '' }}">
    </div>
</form>
