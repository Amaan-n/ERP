@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Product Category Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('product_categories', 'display', $product_category) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Is Active</strong><br>
                            {!! prepare_active_button('product_categories', $product_category) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <strong>name</strong><br>
                            {{ !empty($product_category->name) ? $product_category->name : '-' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! !empty($product_category->description) ? $product_category->description : '-' !!}
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
