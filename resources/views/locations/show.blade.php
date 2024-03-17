@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Location Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('locations', 'display', $location) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active</strong><br>
                            {!! prepare_active_button('locations', $location) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>name</strong><br>
                            {{ !empty($location->name) ? $location->name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! !empty($location->description) ? $location->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>Location</strong><br>
                            {{ !empty($location->location) ? $location->location : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Latitude</strong><br>
                            {{ !empty($location->latitude) ? $location->latitude : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Longitude</strong><br>
                            {{ !empty($location->longitude) ? $location->longitude : '-' }}
                        </div>
                    </div>

                    <div class="row mt-3 mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div id="map" style="height:200px; width:100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script
        src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ config('constants.GOOGLE_MAP_API') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.gmap.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            let latitude = '{{ $location->latitude ?? 29.3673691 }}';
            let longitude = '{{ $location->longitude ?? 47.9677177 }}';
            latitude = parseFloat(latitude);
            longitude = parseFloat(longitude);
            google.maps.event.addDomListener(window, 'load', init_map(latitude, longitude));
        });

        // destination map script
        function init_map(lati, lngi) {
            var mapOptions = {
                mapTypeControl: false,
                center: {lat: lati, lng: lngi},
                zoom: 13,
                scrollwheel: false,
            };
            var map = new google.maps.Map(document.getElementById('map'), mapOptions);
            var myLatlng = new google.maps.LatLng(lati, lngi);
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                title: 'You!',
                animation: google.maps.Animation.DROP,
            });

            var infowindow = new google.maps.InfoWindow({
                content: '{{ $location->location ?? '' }}'
            });
            infowindow.open(map, marker);
        }
    </script>
@stop
