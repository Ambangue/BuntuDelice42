@extends('layouts.app')
@section('title',$restaurant->name.' | Buntu Delice ')
@section('add_restaurant_nav', 'active')
@section('add_restaurant_open_nav', 'menu-open')
@section('add_restaurant_all_nav', 'active')
@section('style')
 <link rel="stylesheet" type="text/css" href="{{asset('slick/slick.css')}}">
 <link rel="stylesheet" type="text/css" href="{{asset('slick/slick-theme.css')}}">
@endsection
@section('content')
 <style type="text/css">
 
    .slider {
        width: 50%;
        margin: 100px auto;
    }

    .slick-slide {
      margin: 0px 10px;
    }

    .slick-slide img {
      width: 100%;
    }

    .slick-prev:before,
    .slick-next:before {
      color: black;
    }


    .slick-slide {
      transition: all ease-in-out .3s;
    }


    .slick-current {
      opacity: 1;
    }
    .slick-next{
     margin-right:5px;   
    }
    .slick-prev{
        margin-left:5px;
    }
  </style>
<section class="content">
<div class="container-fluid">
<div class="row  justify-content-center">
<div class="col-md-12 mt-5 ">
<div class="row py-2" style="background-image: url({{asset('images/restaurant_images/').'/'.$restaurant->cover_image}}); background-size: cover; background-repeat: no-repeat; background-position: center; ">
<div class="col-md-2">
<img src="{{asset('images/restaurant_images/').'/'.$restaurant->logo}}" class="w-100 rounded" alt="logo">
</div>
<div class="col-md-7">
<h3 class="text-white">{{$restaurant->name}}</h3>
<h5 class="text-white">{{$restaurant->slogan}}</h5>
<p class="text-white">{{$restaurant->address}}</p>
<p>{!! str_repeat('<span><i class="fa fa-star checked" style="color: orange;"></i></span>', number_format($restaurant->ratings, 1)) !!}{!! str_repeat('<span><i class="fa fa-star"></i></span>', 5 - number_format($restaurant->ratings, 1)) !!}</p>
</div>
<div class="col-md-3"><p class="text-white float-right"><a href="{{route('restaurant.edit',$restaurant->id)}}" class="text-white">Edit Profile</a></p></div>
</div>
<div class="row mt-3">
<div class="col-md-8 pl-0">
<div class="card shadow">
<div class="card-header">
<h4>Order Management</h4>
</div>
<div class="card-body">
<div class="row">
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Total Orders</span>
<span class="info-box-number text-center text-muted mb-0">{{$totalorders}}</span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Active Orders</span>
<span class="info-box-number text-center text-muted mb-0">{{$getPendings}}</span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Completed Orders</span>
<span class="info-box-number text-center text-muted mb-0">{{$getComleted}} <span>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="card shadow">
<div class="card-header">
<h4>Restaurant Earnings</h4>
</div>
<div class="card-body">
<div class="row">
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Total Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{$OrdersByTotal}}</span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Today Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{$OrdersByDay}}</span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Average Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{number_format($OrdersByDayAvg, 2)}}<span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Admin Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{number_format($adminEarnings, 2)}}<span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Today Admin Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{number_format($adminEarnByDay, 2)}}<span>
</div>
</div>
</div>
<div class="col-12 col-sm-4">
<div class="info-box bg-light">
<div class="info-box-content">
<span class="info-box-text text-center text-muted">Average Admin Earnings</span>
<span class="info-box-number text-center text-muted mb-0">{{number_format($adminEarnByAvg, 2)}}<span>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="row">
                <!-- Left col -->
                <section class="col-lg-12 connectedSortable">
                    <!-- Custom tabs (Charts with tabs)-->
                    <div class="card shadow">
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

</div>
<div class="col-md-4 pr-0">
<div class="card shadow">
<div class="card-header">
<h4>About Restaurant</h4>
</div>
<!-- /.card-header -->
<div class="card-body">
<strong><i class="fas fa-envelope mr-1"></i>Email</strong>

<p class="text-muted">
{{$restaurant->email}}
</p>

<hr>
<strong><i class="fas fa-phone mr-1"></i> Phone</strong>

<p class="text-muted">
{{$restaurant->phone}}
</p>

<hr>

<strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

<p class="text-muted">{{$restaurant->address}}</p>

<hr>
</div>
<!-- /.card-body -->
</div>
<div class="card shadow">
<div class="card-body">
<h4>Offers</h4>
@foreach($restaurant->cuisines as $cuisine)
<span class="badge badge-primary">{{$cuisine->name}}</span>
@endforeach
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
/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  'use strict'


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



})
</script> 

<script>
function logo1(input) {
if (input.files && input.files[0]) {
var reader = new FileReader();

reader.onload = function (e) {
$('#logo')
.attr('src', e.target.result);
};

reader.readAsDataURL(input.files[0]);
}
}
</script>




@endsection
