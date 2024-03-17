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
            $redirect_route = !empty($product)
                ? route('products.update', $product->id)
                : route('products.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="product_form" id="product_form">
                {{ csrf_field() }}

                @if(isset($product))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $product->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $product->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($product)
                                        ? 'Edit Product - ' . '<span class="border-bottom border-dark">' . $product->name . '</span>'
                                        : 'Create Product' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('products', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('products.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($product) ? 'Update Product' : 'Create Product' !!}
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.product_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    product_category_id: 'required',
                    name: 'required',
                    price: 'required',
                }
            });
        });
    </script>
@stop
