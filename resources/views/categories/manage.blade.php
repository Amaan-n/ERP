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
            $redirect_route = !empty($category)
                ? route('categories.update', $category->id)
                : route('categories.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="category_form" id="category_form">
                {{ csrf_field() }}

                @if(isset($category))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" class="category_id"
                           value="{{ $category->id > 0 ? $category->id : 0 }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($category)
                                        ? 'Edit Category - ' . '<span class="border-bottom border-dark">' . $category->name . '</span>'
                                        : 'Create Category' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('categories', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('categories.form')
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg">
                            Submit
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
            $('.category_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });
        });
    </script>
@stop
