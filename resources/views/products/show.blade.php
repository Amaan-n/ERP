@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">
                            Product Detail
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('products', 'display', $product) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('products', $product) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Product Category</strong><br>
                            {{ isset($product->product_category) && !empty($product->product_category->name) ? $product->product_category->name : '' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($product->name) ? $product->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Price</strong><br>
                            {{ !empty($product->price) ? $product->price : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Barcode</strong><br>
                            {{ !empty($product->barcode) ? $product->barcode : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($product->created_by_user) && !empty($product->created_by_user) ? $product->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($product->updated_by_user) && !empty($product->updated_by_user) ? $product->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! !empty($product->description) ? $product->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Attachment</strong><br>
                            @if(isset($product) && !empty($product->attachment))
                                <a href="{{ config('constants.s3.asset_url') . $product->attachment }}"
                                   target="_blank">
                                    <i class="fa fa-image fa-5x"> </i>
                                </a>
                            @else
                                <span>-</span>
                            @endif
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
