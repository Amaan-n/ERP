@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Category Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('categories', 'display', $category) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('categories', $category) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($category->name) ? $category->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($category->created_by_user) && !empty($category->created_by_user) ? $category->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($category->updated_by_user) && !empty($category->updated_by_user) ? $category->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($category) && !empty($category->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $category->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"></i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <strong>Description</strong><br>
                            {{ !empty($category->description) ? $category->description : '-' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            //
        });
    </script>
@stop
