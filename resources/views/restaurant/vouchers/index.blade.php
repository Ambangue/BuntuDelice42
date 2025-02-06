@extends('layouts.app')
@section('title','Vouchers')
@section('vouchers_nav', 'active')
@section('vouchers_nav_open', 'menu-open')
@section('vouchers_nav_index', 'active')
@section('style')

@endsection
@section('content')
    <div class="content-header">
        @if(session()->has('alert'))
            <div id="alert" class="alert alert-{{ session()->get('alert.type') }}">
                {{ session()->get('alert.message') }}
                <i onclick="document.getElementById('alert').style.display = 'none';" class="float-right text-white fa fa-times"></i>
            </div>
        @endif

        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Vouchers</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Vouchers</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Vouchers</h3>
                           
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive ">
                            <table id="example1" class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Discount (%)</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($vouchers as $index => $voucher)
                                    <tr>
                                        <td>{{++$index}}</td>
                                        <td>{{$voucher->name}}</td>
                                        <td>{{$voucher->discount}}</td>
                                        <td>{{$voucher->start_date}}</td>
                                        <td>{{$voucher->end_date}}</td>
                                        <td>
                                            <a href="{{route('voucher.edit',$voucher->id)}}" class="btn btn-outline-info"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                                <form action="{{ route('voucher.destroy', $voucher->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this voucher?');">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->


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
