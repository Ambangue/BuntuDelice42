@extends('layouts.app')
@section('style')
<style>
    .bg-img{
            background-image: url(images/img-4.jpeg);
            background-position: center;
            height: 200px;
            background-size: cover;
}
.profile-img{
            width: 100px;
            height: 100px;
        }
        li{
            list-style-type: none;
        }
</style>
@endsection
@section('user_nav', 'active')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row pt-4">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <h3>150</h3>
  
                  <p>New Orders</p>
                </div>
                <div class="icon">
                  <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>
  
                  <p>Customer Reviews</p>
                </div>
                <div class="icon">
                  <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>44</h3>
  
                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>65</h3>
  
                  <p>Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
        <div class="row">
            <div class="col-md-8">
                <div class="row p-5 bg-img">
                        <div class="col-md-6">
                            <img src="images/user3-128x128.jpg" width="100%" alt="" style="" class="profile-img rounded-circle">
                        </div>
                        <div class="col-md-6 text-light">
                            <h2>Kalz Burger</h2>
                            <p style="font-size: 20px;">A Name of Trust
                            </p>
                        </div>
                    </div>
            </div>
            <div class="col-md-4">
                <div class="card p-2">
                    <p class="text-bold m-0">@ Cuisines, Fast Food</p>
                    <p class="m-0">This is the description or about info of the restaurant. This is the description or about info of the restaurant.</p>
                    <hr class="m-0">
                    <i class="fas fa-phone py-2"><span style="font-weight:300; margin-left:10px;">+92 123 123 1234</span></i>
                    <i class="fas fa-envelope py-1"><span style="font-weight:300; margin-left:10px;">example123@gmail.com</span></i>
                    <div class="row py-1" style="font-size:12px;">
                        <div class="col-4">
                            <li><b>Sunday</b></li>
                        </div>
                        <div class="col-6" >
                            <li><span>7:00 AM</span> - <span>10:00 PM</span></li>
                        </div>
                        <div class="col-1"><i  class="fa fa-chevron-down" onclick="hrs()"></i></div>
                    </div>
                    <div id="hours" style="display:none;">
                        <div class="row" style="font-size:12px;">
                            <div class="col-4">
                                <li><b>Sunday</b></li>
                            </div>
                            <div class="col-6" >
                                <li><span>7:00 AM</span> - <span>10:00 PM</span></li>
                            </div>
                        </div>
                        <div class="row" style="font-size:12px;">
                            <div class="col-4">
                                <li><b>Sunday</b></li>
                            </div>
                            <div class="col-6" >
                                <li><span>7:00 AM</span> - <span>10:00 PM</span></li>
                            </div>
                        </div>
                        <div class="row" style="font-size:12px;">
                            <div class="col-4">
                                <li><b>Sunday</b></li>
                            </div>
                            <div class="col-6" >
                                <li><span>7:00 AM</span> - <span>10:00 PM</span></li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Online Store Visitors</h3>
                        <a href="javascript:void(0);">View Report</a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="text-bold text-lg">820</span>
                          <span>Visitors Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                          <span class="text-success">
                            <i class="fas fa-arrow-up"></i>12.5%
                          </span>
                          <span class="text-muted"></span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
      
                      <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="visitors-chart" height="300" width="1116" class="chartjs-render-monitor" style="display: block; height: 200px; width: 744px;"></canvas>
                      </div>
      
                      
                    </div>
                  </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header border-0">
                      <div class="d-flex justify-content-between">
                        <h3 class="card-title">Posts</h3>
                        <a href="javascript:void(0);">View Report</a>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="d-flex">
                        <p class="d-flex flex-column">
                          <span class="text-bold text-lg"></span>
                          <span>Posts Over Time</span>
                        </p>
                        <p class="ml-auto d-flex flex-column text-right">
                          <span class="text-success">
                            <i class="fas fa-arrow-up"></i> 33.1%
                          </span>
                          <span class="text-muted">Since last month</span>
                        </p>
                      </div>
                      <!-- /.d-flex -->
      
                      <div class="position-relative mb-4"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <canvas id="sales-chart" height="300" style="display: block; height: 200px; width: 744px;" width="1116" class="chartjs-render-monitor"></canvas>
                      </div>
      
                      
                    </div>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Monthly Rating Report</h5>
  
                  <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                      <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                      <i class="fas fa-times"></i>
                    </button>
                  </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <p class="text-center">
                        
                      </p>
  
                      <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                        <!-- Sales Chart Canvas -->
                        <canvas id="salesChart" height="270" style="height: 180px; display: block; width: 491px;" width="736" class="chartjs-render-monitor"></canvas>
                      </div>
                      <!-- /.chart-responsive -->
                    </div>
                    <!-- /.col -->
                    
                    <!-- /.col -->
                  </div>
                  <!-- /.row -->
                </div>
                <!-- ./card-body -->
                
                <!-- /.card-footer -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
</section>
@endsection
@section('script')
<script src="{{ asset(env('ASSET_URL') .'dist/js/pages/dashboard3.js')}}"></script>
<script src="{{ asset(env('ASSET_URL') .'dist/js/pages/dashboard2.js')}}"></script>
<script>
    function hrs(){
    if(document.getElementById("hours").style.display == "none"){
        document.getElementById("hours").style.display = "block";
    }else{
        document.getElementById("hours").style.display = "none";
    }

}
</script>
@endsection