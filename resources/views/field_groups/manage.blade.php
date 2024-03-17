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
            $redirect_route = !empty($field_group)
                ? route('field_groups.update', $field_group->id)
                : route('field_groups.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="field_group_form" id="field_group_form">
                {{ csrf_field() }}

                @if(isset($field_group))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $field_group->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $field_group->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($field_group)
                                        ? 'Edit Field Group - ' . '<span class="border-bottom border-dark">' . $field_group->name . '</span>'
                                        : 'Create Field Group' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('field_groups', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('field_groups.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($field_group) ? 'Update Field Group' : 'Create Field Group' !!}
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
            $('.field_group_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });

            $(document).find('select[name="fields[]"]').select2({
                placeholder: 'Please select a fields',
                allowClear: true
            });
        });
    </script>
@stop
