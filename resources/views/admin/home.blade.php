@extends('layouts.app')
@section('title', 'Dashboard | Buntu Delice')
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
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <a href="{{route('admin.all_orders')}}"> <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content text-dark">
                            <span class="info-box-text">Total Orders</span>
                            <span class="info-box-number">
                              {{ \App\Order::get()->unique('order_no')->count() }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div></a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{url('admin/restaurant')}}"><div class="info-box">
                        <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-building"></i></span>

                        <div class="info-box-content text-dark">
                            <span class="info-box-text">Total Merchants</span>
                            <span class="info-box-number">
                              {{ \App\Restaurant::count() }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div></a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{url('admin/user')}}"><div class="info-box">
                        <span class="info-box-icon bg-gradient-danger elevation-1">
                            <i class=" ion ion-person-add"></i></span>

                        <div class="info-box-content text-dark">
                            <span class="info-box-text">Total Users</span>
                            <span class="info-box-number">
                              {{ \App\User::where('type','user')->count() }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div></a>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <a href="{{url('admin/driver')}}"><div class="info-box">
                        <span class="info-box-icon bg-gradient-warning elevation-1">
                            <i class="text-white fas fa-taxi"></i></span>

                        <div class="info-box-content text-dark">
                            <span class="info-box-text">Total Drivers</span>
                            <span class="info-box-number">
                              {{ \App\Driver::count() }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div></a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{route('total.pro')}}">
                        <div class="info-box">
                        <span class="info-box-icon bg-gradient-warning elevation-1">
                            <i class="text-white fas fa-hamburger"></i></span>

                        <div class="info-box-content text-dark">
                            <span class="info-box-text">Total Products</span>
                            <span class="info-box-number">
                              {{ \App\Product::count() }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div>
                    </a>
                </div>
                <div class="col-lg-3 col-6">
                    <a href="{{url('admin/cuisine')}}">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-success elevation-1">
                            <i class="text-white fas fa-hamburger"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Cuisine</span>
                            <span class="info-box-number">
                              {{ \App\Cuisine::count()}}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div>
                    </a>
                    </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-success elevation-1">
                            <i class="text-white fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Earnings</span>
                            <span class="info-box-number">
                              ${{ number_format(\App\CompletedOrder::get()->unique('order_no')->sum('total'), 2) }}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="info-box">
                        <span class="info-box-icon bg-gradient-info elevation-1">
                            <i class="text-white fas fa-money-bill-alt"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Admin Earnings</span>
                            <span class="info-box-number">
                              ${{ number_format(\App\CompletedOrder::get()->unique('order_no')->sum('total')*0.2, 2)}}
                            </span>
                        </div>
                          <!-- /.info-box-content -->
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="card card-primary">
                          <div class="card-header">
                            <h3 class="card-title">This Year Sales</h3>

                            <div class="card-tools">
                              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                              </button>
                              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
                            </div>
                          </div>
                          <div class="card-body">
                            <div class="chart">
                              <canvas id="areaChart" style="min-height: 250px; height: 300px; max-height: 300px; max-width: 100%;"></canvas>
                            </div>
                          </div>
                          <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
              <div class="card-header border-0">
                <div class="d-flex justify-content-between">
                  <h3 class="card-title">Sales In ( {{date('Y')-1}} - {{date('Y')}} )</h3>
                </div>
              </div>
              <div class="card-body">

                <div class="position-relative mb-4">
                  <canvas id="sales-chart" height="200"></canvas>
                </div>

                <div class="d-flex flex-row justify-content-end">
                  <span class="mr-2">
                    <i class="fas fa-square text-primary"></i> {{date('Y')}}
                  </span>

                  <span>
                    <i class="fas fa-square text-gray"></i> {{date('Y')-1}}
                  </span>
                </div>
              </div>
            </div>
                </div>
            </div>
        </div>
    </section>

    @endsection
@section('script')

<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
  <script type="text/javascript">
    // var myLat;
    // var myLng;
    function abc(){

    }
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        alert( "Geolocation is not supported by this browser.");
    }
    function showPosition(position) {
        var myLat =  parseFloat(position.coords.latitude) ;
         myLat = myLat.toFixed(6);
        var myLng =  parseFloat(position.coords.longitude);
         myLng = myLng.toFixed(6);
         initMap(31.568611,74.405611);
    }
    // Initialize and add the map
    function initMap(lat ,long) {
        // The location of Uluru
        var uluru = { lat: lat, lng: long };
        var latlng = { lat: 31.568531, lng: 74.407717 };
        // The map, centered at Uluru
        var map = new google.maps.Map(
            document.getElementById('map'), { zoom: 15, center: uluru , radius:2000 });
        // The marker, positioned at Uluru

        var marker = new google.maps.Marker({ position: uluru,label:"A", map: map });
        var marker = new google.maps.Marker({ position: latlng,label:"Gori", map: map });
        var myCity = new google.maps.Circle({
            center:uluru,
            radius:500,
            strokeColor:"#0000FF",
            strokeOpacity:0.5,
            strokeWeight:2,
            fillColor:"#0000FF",
            fillOpacity:0.4
            });
            myCity.setMap(map);
    }


  </script>
  <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=Your_api_key&libraries=places&callback=initMap"></script>
<script src="{{ asset(env('ASSET_URL') .'plugins/flot/jquery.flot.js')}}"></script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : [{!!$monthstring!!}],
      datasets: [
        {
          label               : 'This Year Sales',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius          : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [
               {{$total}}
            ]
        },
      ]
    }

    var areaChartOptions = {
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
    var areaChart       = new Chart(areaChartCanvas, { 
      type: 'line',
      data: areaChartData, 
      options: areaChartOptions
    })

  })
</script>
<script>
    $(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode      = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  var salesChart  = new Chart($salesChart, {
    type   : 'bar',
    data   : {
      labels  : ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#6c757d',
          borderColor    : '#6c757d',
          data           : [{{$lasttotal}}]
        },
        {
          backgroundColor: '#007bff',
          borderColor    : '#007bff',
          data           : [{{$total}}]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips           : {
        mode     : mode,
        intersect: intersect
      },
      hover              : {
        mode     : mode,
        intersect: intersect
      },
      legend             : {
        display: false
      },
      scales             : {
        yAxes: [{
          // display: false,
          gridLines: {
            display      : true,
            lineWidth    : '4px',
            color        : 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks    : $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value, index, values) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }
              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display  : true,
          gridLines: {
            display: false
          },
          ticks    : ticksStyle
        }]
      }
    }
  })
    })
</script>
@endsection