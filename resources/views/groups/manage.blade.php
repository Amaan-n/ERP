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
            $redirect_route = !empty($group)
                ? route('groups.update', $group->id)
                : route('groups.store');
            ?>
            <form action="{{ $redirect_route }}" method="post"
                  enctype="multipart/form-data" class="group_form" id="group_form" autocomplete="off">
                {{ csrf_field() }}

                @if(isset($group))
                    <input type="hidden" name="_method" value="put">
                    <input type="hidden" name="id" value="{{ $group->id ?? 0 }}">
                    <input type="hidden" name="slug" value="{{ $group->slug ?? '' }}">
                @endif

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">
                                {!! isset($group)
                                        ? 'Edit Group - ' . '<span class="border-bottom border-dark">' . $group->name . '</span>'
                                        : 'Create Group' !!}
                            </h3>
                        </div>
                        <div class="card-toolbar">
                            {!! prepare_header_html('groups', 'manage') !!}
                        </div>
                    </div>
                    <div class="card-body">
                        @include('groups.form')
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit"
                                class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            {!! isset($group) ? 'Update Group' : 'Create Group' !!}
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
            $('.group_form').validate({
                ignore: ':hidden',
                errorClass: "invalid",
                rules: {
                    name: 'required'
                }
            });

            $(document).off('click', '.select_all_checkboxes');
            $(document).on('click', '.select_all_checkboxes', function () {
                let child_selector = $(this).parents('.parent_module').find('.system_module_checkboxes');
                child_selector.prop('checked', false);
                if ($(this).prop('checked')) {
                    child_selector.prop('checked', true);
                }
            });

            $(document).off('click', '.system_module_checkboxes');
            $(document).on('click', '.system_module_checkboxes', function () {
                check_select_all_checkbox(this);
            });

            $(document).find('.select_all_checkboxes').each(function (key, value) {
                check_select_all_checkbox(value);
            })
        });

        function check_select_all_checkbox(value) {
            let parent_selector = $(value).parents('.parent_module');
            parent_selector.find('.select_all_checkboxes').prop('checked', false);
            if (parent_selector.find('.system_module_checkboxes:checked').length === parent_selector.find('.system_module_checkboxes').length) {
                parent_selector.find('.select_all_checkboxes').prop('checked', true);
            }
        }
    </script>
@stop
