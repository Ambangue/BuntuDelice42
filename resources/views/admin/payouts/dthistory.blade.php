@extends('layouts.app')

@section('dashboard_nav', 'active')

@section('content')

<section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
            <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Driver Transaction History</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>S.No</th>
                      <th>Restaurant</th>
                      <th>Total Amount</th>
                      <th>Transaction ID</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Warner</td>
                      <td>$45</td>
                      <td>0001234</td>
                      <td>
                      <button class="btn btn-success">Make Payment</button>
                      </td>
                      
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>Harry</td>
                      <td>$47</td>
                      <td>0001235</td>
                      <td>
                      <button class="btn btn-success">Make Payment</button>
                      </td>
                      
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