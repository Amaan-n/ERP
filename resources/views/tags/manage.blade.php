@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <span class="font-size-h3 font-weight-bold">Manage Tag</span>
        </div>
        <div class="col-md-6">
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-item font-weight-bold p-0 my-2 font-size-sm mr-5 float-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-muted">HOME</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('tags.index') }}" class="text-muted">TAGS</a>
                </li>
                <li class="breadcrumb-item">
                    MANAGE TAG
                </li>
            </ul>
        </div>

        <div class="col-md-12">
            <hr/>
        </div>
    </div>

    @if(\Illuminate\Support\Facades\Session::has('notification'))
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                    <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                </div>
            </div>
        </div>
    @endif

    <?php
    $redirect_route = !empty($tag)
        ? route('tags.update', $tag->id)
        : route('tags.store');
    ?>
    <form action="{{ $redirect_route }}" method="post"
          enctype="multipart/form-data" class="tag_form" id="tag_form">
        {{ csrf_field() }}
        @if(isset($tag) && !empty($tag))
            <input type="hidden" name="_method" value="put">
            <input type="hidden" name="id" class="tag_id"
                   value="{{ isset($tag->id) && $tag->id > 0 ? $tag->id : 0 }}">
        @endif

        <div class="row">
            <div class="col-md-8 pt-10">
                @include('tags.form')
            </div>

            <div class="col-md-4 pt-10 product_form_purpose">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <p class="font-weight-bolder text-uppercase mb-10">Purpose of the Form:</p>
                        <p>Option to select and create the type of tag in-order for the asset.</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.tag_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    provider: 'required',
                    chip_order_name: 'required',
                    value: 'required',
                    quantity: {
                        number: true,
                        min: 1,
                        max: 100
                    }
                }
            });
        });
    </script>
@stop
