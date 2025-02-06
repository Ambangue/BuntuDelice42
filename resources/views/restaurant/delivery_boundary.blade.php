@extends('layouts.app')
@section('title','Delivery Boundries')
@section('delivery_boundary_nav', 'active')
@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Delivery Range</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Range</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<section class="content">
    <div class="container-fluid">

        <div class="row">
		<div id="map" style="height:450px; width:100%; display:none;"></div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3403.172739511514!2d74.2416731144813!3d31.46443405705164!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39190354d1b26e45%3A0x8847a66d4be8a3ae!2sSigi%20Technologies!5e0!3m2!1sen!2s!4v1582617816992!5m2!1sen!2s"  height="450" frameborder="0" style="border:0; width:100%;" allowfullscreen=""></iframe>
        </div>
    </div>
</section>
@endsection
@section('script')
    <script>
        function showLoc(lat,long) {
            var latn = parseFloat(lat);
            var longn = parseFloat(long);
            initMap(latn, longn);
            document.getElementById('imap').style.display = "none";
            document.getElementById('map').style.display = "block";
        }
    </script>
    <script>
        // Initialize and add the map
        function initMap(lat ,long) {
            // The location of Uluru
            var uluru = { lat: lat, lng: long };
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), { zoom: 15, center: uluru , radius:2000 });
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({ position: uluru, map: map });
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
    <script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=Your_Key&libraries=places&callback=initMap"></script>
@endsection
