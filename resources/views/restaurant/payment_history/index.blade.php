@extends('layouts.app')
@section('title','Payment History')
@section('earnings_nav', 'active')
@section('style')

@endsection
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
                    <h1 class="m-0 text-dark">Payment History</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">History</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row justify-content-center">
                <div class="col-11">
                <div class="row">
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Available for Withdrawal</span>
                <span class="info-box-number">
                  {{number_format($total-$withdrwan, 2)}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Net Income</span>
                <span class="info-box-number">{{number_format($Total_Earning, 2)}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-dollar-sign"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Withdrawn Payments</span>
                <span class="info-box-number">{{$withdrwan}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header card-primary p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-p-hist-tab" data-toggle="pill" href="#custom-tabs-three-p-hist" role="tab" aria-controls="custom-tabs-three-p-hist" aria-selected="true">Payment History</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-p-send-tab" data-toggle="pill" href="#custom-tabs-three-p-send" role="tab" aria-controls="custom-tabs-three-p-send" aria-selected="false">Send Payment Request</a>
                              </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-three-p-hist" role="tabpanel" aria-labelledby="custom-tabs-three-p-hist-tab">
                                  <div class="card shadow">
                                    <div class="card-header">
                                      <h3></h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                      <table id="example1" class="table table-head-fixed text-nowrap">
                                        <thead>
                                          <tr>
                                            <th>Id</th>
                                            <th>Transaction Id</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          @foreach($history as $index => $his)
                                          <tr>
                                            <td>{{++$index}}</td>
                                            <td>{{$his->transaction_id}}</td>
                                            <td>{{$his->payout_amount}}</td>
                                            <td>{{$his->created_at}}</td>
                                            <td>{{$his->status}}</td>
                                            <td>
                                              <a title="View" href="#"
                                                class="btn btn-outline-warning" ><i class="fa fa-eye"></i>
                                              </a>
                                            </td>
                                          </tr>
                                          @endforeach
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade show " id="custom-tabs-three-p-send" role="tabpanel" aria-labelledby="custom-tabs-three-p-send-tab">
                                  <div class="card shadow">
                                    <div class="card-header">
                                      <h3></h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                    <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Withdraw Earnings</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post" action="{{route('r_earnings.store')}}">
              @csrf
              <input type="hidden" name="restaurant_id" value="{{auth()->user()->restaurant()->first()->id}}">
              <div class="card-body">
                  @if($withdrwan > 50)
                <div class="row">
                <div class="col-3">
                </div>
                  <div class="col-3">
                    <input type="number" class="form-control" name="amount" placeholder="Enter Amount" min="50" max="500">
                  </div>
                  <div class="col-3">
                  <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  <div class="col-3">
                </div>
                </div>
                @else
                <div class="row">
                <div class="col-12">
                    <p class="text-center">You have not enough money to withdraw!</p>
                </div>
                </div>
                @endif
              </div>
              </form>
            </div>
            <!-- /.card -->
                                    </div>
                                  </div>
                                </div>
                            </div>
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
      $("#example11").DataTable();
      $("#example12").DataTable();
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
