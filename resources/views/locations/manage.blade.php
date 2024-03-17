@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <?php
            $redirect_route = !empty($location)
                ? route('locations.update', $location->id)
                : route('locations.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="location_form" id="location_form">
                {{ csrf_field() }}

                @if(isset($location))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $location->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $location->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($location)
                                        ? 'Edit Location - ' . '<span class="border-bottom border-dark">' . $location->name . '</span>'
                                        : 'Create Location' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('locations', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('locations.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($location) ? 'Update Location' : 'Create Location' !!}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('page_js')
    <script
        src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key={{ config('constants.GOOGLE_MAP_API') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.gmap.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.location_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });

            $(document).off('change', '#autocomplete');
            $(document).on('change', '#autocomplete', function () {
                setTimeout(function () {
                    codeAddress();
                }, 500);
            });
        });

        function initialize() {
            var address = (document.getElementById('autocomplete'));
            var autocomplete = new google.maps.places.Autocomplete(address);
            autocomplete.setTypes(['geocode']);
            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    return;
                }
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);

        function codeAddress() {
            geocoder = new google.maps.Geocoder();
            var address = document.getElementById("autocomplete").value;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    var response_latitude = results[0].geometry.location.lat();
                    var response_longitude = results[0].geometry.location.lng();

                    document.getElementById('latitude').value = response_latitude;
                    document.getElementById('longitude').value = response_longitude;

                    init_map(response_latitude, response_longitude);
                } else {
                    $('#latitude').val('');
                    $('#longitude').val('');
                    //alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }

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
                draggable: true,
            });

            var infowindow = new google.maps.InfoWindow({
                content: "You are here."
            });
            google.maps.event.addListener(marker, 'click', function () {
                infowindow.open(map, marker);
                if (marker.getAnimation() != null) {
                    marker.setAnimation(null);
                } else {
                    marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            });
            infowindow.open(map, marker);

            google.maps.event.addListener(marker, 'dragend', function () {
                // updating the marker position
                var latLng2 = marker.getPosition();
                var geocoder = new google.maps.Geocoder();
                document.getElementById("latitude").value = latLng2.lat();
                document.getElementById("longitude").value = latLng2.lng();

                var latlngplace = new google.maps.LatLng(latLng2.lat(), latLng2.lng());
                geocoder.geocode({'latLng': latlngplace}, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            document.getElementById("autocomplete").value = results[1].formatted_address;
                        } else {
                            alert('No Address Found');
                        }
                    } else {
                        alert('Geocoder failed due to: ' + status);
                    }
                });
            });
        }

        @if(request()->route()->getName() === 'locations.create')
        google.maps.event.addDomListener(window, 'load', init_map(29.3673691, 47.9677177));
        @endif

        @if(request()->route()->getName() === 'locations.edit')
        let latitude = '{{ $location->latitude ?? 29.3673691 }}';
        let longitude = '{{ $location->longitude ?? 47.9677177 }}';
        latitude = parseFloat(latitude);
        longitude = parseFloat(longitude);
        google.maps.event.addDomListener(window, 'load', init_map(latitude, longitude));
        @endif
    </script>
@stop
