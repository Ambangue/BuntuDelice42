@extends('layouts.app')
@section('title','Product')
@section('product_nav', 'active')
@section('style')

@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Products</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
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
                            <h3 class="card-title">All Products</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive ">
                            <table id="example1" class="table table-head-fixed text-nowrap">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Price</th>
                                    <th>Discount Price</th>
                                    <th>Featured</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $index=>$product)
                                    <tr>
                                        <th>{{++$index}}</th>
                                        <td>{{$product->name}}</td>
                                        <td><img class="img" width="100" src="../images/product_images/{{ $product->image }}"
                                                 alt=""></td>
                                        <td>{{$product->price}}</td>
                                        <td>{{$product->discount_price}}</td>
                                        <td>
                                            <a href="{{ route('restaurant.change_product_featured_status', $product->id) }}">
                                                <span
                                                    class="badge badge-{{ $product->featured ? 'success' : 'danger' }}">{{ $product->featured ? 'Featured' : 'Non Featured' }}</span>
                                            </a>
                                        </td>
                                        <td>
                                            <a title="View" href=""
                                                class="btn btn-outline-warning" data-toggle="modal" data-target="#modal-default{{$index}}"><i class="fa fa-eye"></i></a>
                                            <a title="Edit" href="{{ route('product.edit', $product->id) }}"
                                               class="btn btn-outline-info"><i class="fa fa-pen"></i></a>
                                            <a title="Delete" href="javascript:void(0);" onclick="$(this).find('form').submit();"
                                               class="btn btn-outline-danger">
                                                <i class="fa fa-trash-alt"></i>
                                                <form action="{{ route('product.destroy', $product->id) }}"
                                                      method="post"
                                                      onsubmit="return confirm('Do you really want to delete this product?');">
                                                    @csrf
                                                    @method('delete')
                                                </form>
                                            </a>

                                        </td>
                                        <div class="modal fade" id="modal-default{{$index}}">
                                            <div class="modal-dialog">
                                              <div class="modal-content">
                                                <div class="modal-header">
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card card-default">
                                                                <img class="w-100 mb-3" height="300" src="../images/product_images/{{ $product->image }}"  alt="">
                                                            </div>
                                                            <div class="card card-{{ $product->featured ? 'success' : 'danger' }} card-outline">
                                                                <div class="card-header">
                                                                    <h3><b>{{$product->name}}</b></h3>
                                                                </div>
                                                                <div class="card-body">
                                                                    <div class="row">                       
                                                                        <div class="col-5 col-sm-4">
                                                                        <div class="nav flex-column nav-tabs h-100" id="vert-tabs-tab" role="tablist" aria-orientation="vertical">
                                                                          <a class="nav-link active" id="vert-tabs-desc{{$index}}-tab" data-toggle="pill" href="#vert-tabs-desc{{$index}}" role="tab" aria-controls="vert-tabs-desc{{$index}}" aria-selected="true">Description</a>
                                                                          <a class="nav-link" id="vert-tabs-category{{$index}}-tab" data-toggle="pill" href="#vert-tabs-category{{$index}}" role="tab" aria-controls="vert-tabs-category{{$index}}" aria-selected="false">Category</a>
                                                                          <a class="nav-link" id="vert-tabs-feature{{$index}}-tab" data-toggle="pill" href="#vert-tabs-feature{{$index}}" role="tab" aria-controls="vert-tabs-feature{{$index}}" aria-selected="false">Featured</a>
                                                                          <a class="nav-link" id="vert-tabs-price{{$index}}-tab" data-toggle="pill" href="#vert-tabs-price{{$index}}" role="tab" aria-controls="vert-tabs-price{{$index}}" aria-selected="false">Price</a>
                                                                        </div>
                                                                      </div>
                                                                      <div class="col-7 col-sm-8">
                                                                        <div class="tab-content" id="vert-tabs-tabContent">
                                                                            <div class="tab-pane text-left fade show active" id="vert-tabs-desc{{$index}}" role="tabpanel" aria-labelledby="vert-tabs-desc-tab">
                                                                                {{$product->description}}
                                                                            </div>
                                                                            <div class="tab-pane fade" id="vert-tabs-category{{$index}}" role="tabpanel" aria-labelledby="vert-tabs-category-tab">
                                        {{DB::table('categories')->where('id',$product->category_id)->value('name')}}
                                                                            </div>
                                                                            <div class="tab-pane fade" id="vert-tabs-feature{{$index}}" role="tabpanel" aria-labelledby="vert-tabs-feature-tab">
                                                                                <span class=" badge badge-{{ $product->featured ? 'success' : 'danger' }}"> {{ $product->featured ? 'Featured' : 'Non Featured' }}</span>
                                                                            </div>
                                                                            <div class="tab-pane fade" id="vert-tabs-price{{$index}}" role="tabpanel" aria-labelledby="vert-tabs-price-tab">
                                                                                <label>Price:</label>
                                                                                <p class="ml-3"> {{$product->price}}</p>
                                                                                <label>Discounted Price:</label>
                                                                                <p class="ml-3"> {{$product->discount_price}}</p>
                                                                            </div>
                                                                        </div>
                                                                      </div>                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                </div>
                                              </div>
                                              <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
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
