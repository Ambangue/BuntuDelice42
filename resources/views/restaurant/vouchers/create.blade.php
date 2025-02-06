@extends('layouts.app')
@section('title','Add Vouchers')
@section('vouchers_nav', 'active')
@section('vouchers_nav_open', 'menu-open')
@section('vouchers_nav_create', 'active')
@section('style')

@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Add Vouchers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('voucher.index')}}">Vouchers</a></li>
                        <li class="breadcrumb-item active">Create Vouchers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md-7 col-xs-12">

                    <div class="card">
                        <div class="card-header">
                            <h4>Create Your Own Voucher</h4>
                        </div>
                        <div class="card-body">
                            <form role="form" method="post" action="{{route('voucher.store')}}">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" class="form-control" placeholder="Enter the name of voucher" required />
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="discount">Discount (%)</label>
                                        <input type="text" name="discount" class="form-control" placeholder="Enter discount in %" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="start_date">From</label>
                                        <input type="date" name="start_date" class="form-control" required />
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label for="end_date">To</label>
                                        <input type="date" name="end_date" class="form-control" required />
                                    </div>
                                </div>
                                <div class="form-row mt-3">
                                    <div class="form-group col-12">
                                        <button type="submit" class="btn bg-gradient-success">Add Coupon</button>
                                        <button type="reset" class="btn bg-gradient-danger">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 d-sm-block">
                    <div class="card mx-5">
                        <div class="card-body">
                            <img src="{{asset('images/coupons.jpg')}}" width="300" height="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
    $(function () {
      $("#example1").DataTable();
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
      });
    });
  </script>
@endsection
