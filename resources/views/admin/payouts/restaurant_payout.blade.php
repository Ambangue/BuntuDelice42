@extends('layouts.app')
@section('title', 'Restaurant Payouts | Buntu Delice')
@section('style')
<link rel="stylesheet" href="{{asset(env('ASSET_URL') .'/plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
<link rel="stylesheet" href="{{asset(env('ASSET_URL').'/plugins/sweetalert2/sweetalert2.css')}}">
@endsection
@section('payout_nav', 'active')
@section('payout_nav_open', 'menu-open')
@section('payout_nav_restaurant', 'active')

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
                    <h1 class="m-0 text-dark">Payouts Requests</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Payouts Requests</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
   
            <div class="row">
          <div class="col-12 col-sm-12 col-lg-12">
            <div class="card card-primary card-tabs shadow">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                  <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true"><b>Requests For Payouts</b></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false"><b>Paid Histroy</b></a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">
                  <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                    <div class="card shadow">
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive shadow p-5">
                            <table class="table table-head-fixed text-nowrap" id="example1">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Lic#</th>
                                    <th>Restaurant</th>
                                    <th>Phone Number</th>
                                    
                                    <th>Amount to Pay</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($requests as $index=> $request)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($request->date)->diffForhumans() }}</td>
                                    <td>{{++$index}}</td>
                                    <td>{{$request->name}}</td>
                                    <td>{{$request->phone}}</td>
                                    
                                    <td>${{$request->payout_amount}}</td>
                                    <td>{{$request->status}}</td>
                                    <td>
                                        <button class="btn btn-success" title="Send Payment" data-toggle="modal" data-target="#modal-sm{{$request->request_id}}"><i class="fa fa-paper-plane"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-sm{{$request->request_id}}">
        <div class="modal-dialog modal-sm">
        <form action="{{route('restaurant_pay')}}" method="post">
        @csrf
        <input type="hidden" name="request_id" value="{{$request->request_id}}">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">PAYOUTS</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
            
                <div class="card-body">
                  <div class="form-group">
                    <label for="transaction_id">Transaction Id</label>
                    <input type="text" class="form-control" name="transaction_id" placeholder="Transaction Id" required>
                  </div>
                </div>
              
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary btn-sm">Pay Now</button>
            </div>
          </div>
          </form>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div> 
                  </div>
                  <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                      <div class="card shadow">
                        
                        <!-- /.card-header -->
                        <div class="card-body table-responsive shadow p-5">
                            <table class="table table-head-fixed text-nowrap" id="example2">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Lic#</th>
                                    <th>Restaurant</th>
                                    <th>Phone Number</th>
                                    
                                    <th>Amount to Pay</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($history as $index=> $request)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($request->date)->diffForhumans() }}</td>
                                    <td>{{++$index}}</td>
                                    <td>{{$request->name}}</td>
                                    <td>{{$request->phone}}</td>
                                    
                                    <td>${{$request->payout_amount}}</td>
                                    <td>{{$request->status}}</td>
                                    <td>
                                        <button class="btn btn-success" title="Show Details" data-toggle="modal" data-target="#modal-lg{{$request->request_id}}"><i class="fa fa-eye"></i></button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="modal-lg{{$request->request_id}}">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Receipt Of Payout</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                 <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  From
                  <address>
                    <strong>{{auth()->user()->name}}</strong><br>
                    {{auth()->user()->address}}<br>
                    Phone: {{auth()->user()->phone}}<br>
                    Email: {{auth()->user()->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  To
                  <address>
                    <strong>John Doe</strong><br>
                    {{$request->address}}<br>
                    Phone: {{$request->phone}}<br>
                    Email: {{$request->email}}
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Invoice #{{$request->transaction_id}}</b><br>
                  <br>
                  <b>Payment Due:</b> {{$request->date}}<br>
                  <b>Paid Amount:</b> ${{$request->payout_amount}}
                </div>
                <!-- /.col -->
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card -->
            </div>
          </div>
             </div>
        </div>
    </section>
@endsection
@section('script')
<script src="{{asset(env('ASSET_URL') .'plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset(env('ASSET_URL') .'plugins/datatables-bs4/js/dataTables.bootstrap4.js')}}"></script>
<script>
    $(function () {
      $("#example1").DataTable();
      $("#example2").DataTable();
    });
  </script>
@endsection