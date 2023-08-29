@extends('admin.layouts.main')
@section('content')
<div class="pagetitle">
    <h1>Fleet</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="">Fleet</a></li>
            <li class="breadcrumb-item active">Fleet Tracking</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="">Driver</label>
                <select name="" id="" class="form-select form-control">
                    @foreach($drivers as $driver)
                    <option value="{{$driver->driver_id}}">{{$driver->driver_name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="site-map">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31001.77636444362!2d103.85575696196273!3d1.3105197518141583!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31da19d17e96b4cb%3A0xc38ff49f290bce44!2sBoon%20Keng!5e0!3m2!1sen!2sin!4v1691481935281!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
               </div>
        </div>
    </div>
</section>

@endsection