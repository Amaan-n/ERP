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
            $redirect_route = !empty($product_category)
                ? route('product_categories.update', $product_category->id)
                : route('product_categories.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="product_category_form" id="product_category_form">
                {{ csrf_field() }}

                @if(isset($product_category))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $product_category->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $product_category->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($product_category)
                                        ? 'Edit Product Category - ' . '<span class="border-bottom border-dark">' . $product_category->name . '</span>'
                                        : 'Create Product Category' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('product_categories', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('product_categories.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($product_category) ? 'Update Product Category' : 'Create Product Category' !!}
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
            $('.product_category_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });
        });
    </script>
@stop
