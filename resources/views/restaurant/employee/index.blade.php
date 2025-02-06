@extends('layouts.app')

@section('employee_nav', 'active')

@section('content')
    <div class="content-header">
        @if(session()->has('alert'))
            <div class="alert alert-{{ session()->get('alert.type') }}">
                {{ session()->get('alert.message') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Employees</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
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
                            <h3 class="card-title">All Employees</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive ">
                            <table id="example1" class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($employees as $index=>$employee)
                                    <tr>
                                        <th>{{++$index}}</th>
                                        <td>{{$employee->name}}</td>
                                        <td><img class="img" width="100" src="../images/employee_images/{{ $employee->image }}"
                                                 alt="image"></td>
                                        <td>{{$employee->email}}</td>
                                        <td>{{$employee->phone}}</td>
                                        <td>
                                            {{$employee->address}}
                                        </td>
                                        <td>
                                            {{--                                            <a href="{{ route('product.show', $product->id) }}"--}}
                                            {{--                                               class="btn btn-outline-info">View</a>--}}
                                            <a href="{{ route('employee.edit', $employee->id) }}"
                                               class="btn btn-outline-info"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                                <form action="{{ route('employee.destroy', $employee->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this employee?');">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>

                                        </td>
                                        @endforeach
                                    </tr>
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
    });
  </script>
@endsection