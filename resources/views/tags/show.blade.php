@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Tag Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        <a href="{{ route('tags.index') }}" class="btn btn-primary font-weight-bolder">
                <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg"
                             xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                             height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"/>
                                <circle fill="#000000" cx="9" cy="15" r="6"/>
                                <path
                                    d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z"
                                    fill="#000000" opacity="0.3"/>
                            </g>
                        </svg>
                    <!--end::Svg Icon-->
                    </span>
                            Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>Chip Order Name</strong><br>
                            {{ !empty($tag->chip_order_name) ? $tag->chip_order_name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Value</strong><br>
                            {{ !empty($tag->value) ? $tag->value : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Created Date</strong><br>
                            {{ !empty($tag->created_at) ? \Carbon\Carbon::createFromTimestamp(strtotime($tag->created_at))->format('dS F, Y') : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Attachment</strong><br>
                            <a href="{{ config('constants.s3.asset_url') . $tag->attachment }}" target="_blank">
                                <i class="fa fa-image fa-5x"> </i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script>
        $(document).ready(function () {
            //
        });
    </script>
@stop
