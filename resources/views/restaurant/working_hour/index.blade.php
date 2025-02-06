@extends('layouts.app')
@section('title', 'Working Hours')
@section('working_hour_nav', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Working Hours</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Working Hours </li>
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
                            <h3 class="card-title">Weekly Working Hours</h3>

                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search"
                                           class="form-control float-right form-control-lg" placeholder="Search">

                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default"><i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Day</th>
                                    <th>Opening Hour</th>
                                    <th>Closing Hour</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($working_hours as $index=>$working_hour)
                                    <tr>
                                        <th>{{++$index}}</th>
                                        <td>{{$working_hour->Day}}</td>
                                        <td>{{$working_hour->opening_time}}</td>
                                        <td>{{$working_hour->closing_time}}</td>
                                        <td>
                                            {{--                                            <a href="{{ route('product.show', $product->id) }}"--}}
                                            {{--                                               class="btn btn-outline-info">View</a>--}}
                                            <a href="{{ route('working_hour.edit', $working_hour->id) }}"
                                               class="btn btn-outline-info">Edit</a>
                                            <a href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                Delete
                                                <form action="{{ route('working_hour.destroy', $working_hour->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete?');">
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
