@extends('layouts.app')
@section('title','Payment History')
@section('earnings', 'active')
@section('style')

@endsection
@section('content')
    <div class="content-header">
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa fa-history text-success" style="font-size:40px;"></i>
                                    <h5><b>{{$Total_Earning}}</b></h5>
                                    <p><b>Total Earnings</b></p>
                                    <div class="progress progress-sm active">
                                      <div class="progress-bar bg-success progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 70%">
                                        <span class="sr-only">20% Complete</span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa fa-dollar-sign text-info" style="font-size:40px;"></i>
                                    <h5><b>{{$this_week_earning}}</b></h5>
                                    <p><b>This Week</b></p>
                                    <div class="progress progress-sm active">
                                      <div class="progress-bar bg-info progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                        <span class="sr-only">20% Complete</span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <i class="fa fa-dollar-sign text-warning" style="font-size:40px;"></i>
                                    <h5><b>{{$today_earning}}</b></h5>
                                    <p><b>Today's Earnings</b></p>
                                    <div class="progress progress-sm active">
                                      <div class="progress-bar bg-warning progress-bar-striped" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                        <span class="sr-only">20% Complete</span>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-three-p-hist-tab" data-toggle="pill" href="#custom-tabs-three-p-hist" role="tab" aria-controls="custom-tabs-three-p-hist" aria-selected="true">Payment History</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-p-rec-tab" data-toggle="pill" href="#custom-tabs-three-p-rec" role="tab" aria-controls="custom-tabs-three-p-rec" aria-selected="false">Payment Recieved</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-three-p-send-tab" data-toggle="pill" href="#custom-tabs-three-p-send" role="tab" aria-controls="custom-tabs-three-p-send" aria-selected="false">Payment Send</a>
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
                                            <th>Order_Id</th>
                                            <th>Payment_Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>1</td>
                                            <td>1012</td>
                                            <td>Cash on delivery</td>
                                            <td>$ 500</td>
                                            <td>Recieved</td>
                                            <td>
                                              <a title="View" href=""
                                                class="btn btn-outline-warning" ><i class="fa fa-eye"></i>
                                              </a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                                <div class="tab-pane fade show " id="custom-tabs-three-p-rec" role="tabpanel" aria-labelledby="custom-tabs-three-p-rec-tab">
                                  <div class="card shadow">
                                    <div class="card-header">
                                      <h3></h3>
                                    </div>
                                    <div class="card-body table-responsive">
                                      <table id="example11" class="table table-head-fixed text-nowrap">
                                        <thead>
                                          <tr>
                                            <th>Id</th>
                                            <th>Order_Id</th>
                                            <th>Payment_Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>1</td>
                                            <td>1012</td>
                                            <td>Cash on delivery</td>
                                            <td>$ 500</td>
                                            <td>Recieved</td>
                                            <td>
                                              <a title="View" href=""
                                                class="btn btn-outline-warning" ><i class="fa fa-eye"></i>
                                              </a>
                                            </td>
                                          </tr>
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
                                      <table id="example12" class="table table-head-fixed text-nowrap">
                                        <thead>
                                          <tr>
                                            <th>Id</th>
                                            <th>Order_Id</th>
                                            <th>Payment_Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td>1</td>
                                            <td>1012</td>
                                            <td>Cash on delivery</td>
                                            <td>$ 500</td>
                                            <td>Recieved</td>
                                            <td>
                                              <a title="View" href=""
                                                class="btn btn-outline-warning" ><i class="fa fa-eye"></i>
                                              </a>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
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
