@extends('layouts.app')
@section('title','Dashboard')
@section('dashboard_nav', 'active')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->

<!-- <p>Click the button to get your coordinates.</p>

<button onclick="getLocation()">Try It</button>

<p id="demo"></p> -->

        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">

                    <div class="small-box ">
                        <div class="inner">

                            <h3>{{$totalorders}}</h3>

                            <p>Total Orders</p>
                        </div>
                        <div class="icon">
                            <i class="text-info ion ion-bag"></i>
                        </div>
                        <a href="{{route('restaurant.all_orders')}}" class="bg-info small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box ">
                        <div class="inner">
                            <h3>{{$categories->count()}}</h3>

                            <p>Total Categories</p>
                        </div>
                        <div class="icon">
                            <i class="text-success ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('category.index')}}" class="bg-success small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box ">
                        <div class="inner">
                            <h3>{{$products->count()}}</h3>

                            <p>Total Products</p>
                        </div>
                        <div class="icon">
                            <i class="text-danger ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('product.index')}}" class="bg-danger small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">

                    <div class="small-box ">
                        <div class="inner">

                            <h3>{{$getPendings}}</h3>

                            <p>New Orders</p>
                        </div>
                        <div class="icon">
                            <i class="text-danger ion ion-bag"></i>
                        </div>
                        <a href="{{route('restaurant.all_orders')}}" class="bg-danger small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box ">
                        <div class="inner">
                            <h3>{{$subscriptions->count()}}</h3>

                            <p>Assigned Orders</p>
                        </div>
                        <div class="icon">
                            <i class="text-warning ion ion-person-add"></i>
                        </div>
                        <a href="{{route('restaurant.pending_orders')}}" class="bg-warning small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-4 col-6">

                    <div class="small-box ">
                        <div class="inner">

                            <h3>{{$getComleted}}</h3>

                            <p>Completed Orders</p>
                        </div>
                        <div class="icon">
                            <i class="text-info ion ion-bag"></i>
                        </div>
                        <a href="{{route('restaurant.complete_orders')}}" class="bg-info small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Monthly Sales
                            </h3>
                            <div class="card-tools">
                                <ul class="nav nav-pills ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Sales</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#sales-chart" data-toggle="tab">Orders</a>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content p-0">
                                <!-- Morris chart - Sales -->
                                <div class="chart tab-pane active" id="revenue-chart"
                                     style="position: relative; height: 300px;">
                                    <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                                <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;">
                                    <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    
                </section>
                </div>
                <div class="row">
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-12 connectedSortable">
                  
                   <!-- solid sales graph -->
                    <div class="card bg-gradient-info">
                        <div class="card-header border-0">
                            <h3 class="card-title">
                                <i class="fas fa-th mr-1"></i>
                                Sales by year
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <canvas class="chart" id="line-chart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                        <!-- /.card-body -->
                        <!--<div class="card-footer bg-transparent">-->
                        <!--    <div class="row">-->
                        <!--        <div class="col-4 text-center">-->
                        <!--            <input type="text" class="knob" data-readonly="true" value="20" data-width="60"-->
                        <!--                   data-height="60"-->
                        <!--                   data-fgColor="#39CCCC">-->

                        <!--            <div class="text-white">Mail-Orders</div>-->
                        <!--        </div>-->
                                <!-- ./col -->
                        <!--        <div class="col-4 text-center">-->
                        <!--            <input type="text" class="knob" data-readonly="true" value="50" data-width="60"-->
                        <!--                   data-height="60"-->
                        <!--                   data-fgColor="#39CCCC">-->

                        <!--            <div class="text-white">Online</div>-->
                        <!--        </div>-->
                                <!-- ./col -->
                        <!--        <div class="col-4 text-center">-->
                        <!--            <input type="text" class="knob" data-readonly="true" value="30" data-width="60"-->
                        <!--                   data-height="60"-->
                        <!--                   data-fgColor="#39CCCC">-->

                        <!--            <div class="text-white">In-Store</div>-->
                        <!--        </div>-->
                                <!-- ./col -->
                        <!--    </div>-->
                            <!-- /.row -->
                        <!--</div>-->
                        <!-- /.card-footer -->
                    </div>
                    <!-- /.card -->
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    
@endsection
@section('script')
 <script>
/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict'

  /* jQueryKnob */
  $('.knob').knob()

 
  
 

  /* Chart.js Charts */
  // Sales chart
  var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesChartData = {
    labels  : [{!!$monthstring!!}],
    datasets: [
      {
        label               : 'Total Earnings',
        backgroundColor     : 'rgba(60,141,188,0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [{{$total}}]
      },
      {
        label               : 'Total Orders',
        backgroundColor     : 'rgba(210, 214, 222, 1)',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : [{{$count}}]
      },
    ]
  }

  var salesChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false
    },
    scales: {
      xAxes: [{
        gridLines : {
          display : false,
        }
      }],
      yAxes: [{
        gridLines : {
          display : false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesChart = new Chart(salesChartCanvas, { 
      type: 'line', 
      data: salesChartData, 
      options: salesChartOptions
    }
  )

  // Donut Chart
  var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
  var pieData        = {
    labels: [
        'Pendings Orders', 
        'Completed Orders',
        'Canceled Orders', 
    ],
    datasets: [
      {
        data: [{{$getPendingAvg}},{{$getCompletedAvg}},{{$getCanceledAvg}}],
        backgroundColor : ['#f56954', '#00a65a', '#f39c12'],
      }
    ]
  }
  var pieOptions = {
    legend: {
      display: false
    },
    maintainAspectRatio : false,
    responsive : true,
  }
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  var pieChart = new Chart(pieChartCanvas, {
    type: 'doughnut',
    data: pieData,
    options: pieOptions      
  });

  // Sales graph chart
  var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d');
  //$('#revenue-chart').get(0).getContext('2d');

  var salesGraphChartData = {
    labels  : [{!!$yearstring!!}],
    datasets: [
      {
        label               : 'Orders',
        fill                : false,
        borderWidth         : 2,
        lineTension         : 0,
        spanGaps : true,
        borderColor         : '#efefef',
        pointRadius         : 3,
        pointHoverRadius    : 7,
        pointColor          : '#efefef',
        pointBackgroundColor: '#efefef',
        data                : [{{$totalYearBy}}]
      }
    ]
  }

  var salesGraphChartOptions = {
    maintainAspectRatio : false,
    responsive : true,
    legend: {
      display: false,
    },
    scales: {
      xAxes: [{
        ticks : {
          fontColor: '#efefef',
        },
        gridLines : {
          display : false,
          color: '#efefef',
          drawBorder: false,
        }
      }],
      yAxes: [{
        ticks : {
          stepSize: 5000,
          fontColor: '#efefef',
        },
        gridLines : {
          display : true,
          color: '#efefef',
          drawBorder: false,
        }
      }]
    }
  }

  // This will get the first returned node in the jQuery collection.
  var salesGraphChart = new Chart(salesGraphChartCanvas, { 
      type: 'line', 
      data: salesGraphChartData, 
      options: salesGraphChartOptions
    }
  )

})
</script> 

@endsection