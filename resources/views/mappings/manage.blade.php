@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <span class="font-size-h3 font-weight-bold">Tags Mapping</span>
        </div>
        <div class="col-md-6">
            <ul class="breadcrumb breadcrumb-transparent breadcrumb-item font-weight-bold p-0 my-2 font-size-sm mr-5 float-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-muted">HOME</a>
                </li>
                <li class="breadcrumb-item">
                    TAGS MAPPING
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

    <form action="{{ route('mappings.store') }}" method="post"
          enctype="multipart/form-data" class="map_tag_form" id="map_tag_form">
        {{ csrf_field() }}

        <div class="row">
            <div class="col-md-8 pt-10">
                @include('mappings.form')
            </div>

            <div class="col-md-4 pt-10 product_form_purpose">
                <div class="card card-custom gutter-b">
                    <div class="card-body">
                        <p class="font-weight-bolder text-uppercase mb-10">Purpose of the Form:</p>
                        <p>Page to map the tags with the asset</p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).find('select[name="tag_id"]').select2({
                placeholder: 'Please select a tag',
                allowClear: false
            });

            $('.map_tag_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    asset_id: 'required'
                }
            });
        });
    </script>
@stop
