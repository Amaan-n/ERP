@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">Field Detail</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('fields', 'display', $field) !!}
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <strong>Is Active?</strong><br>
                            {!! prepare_active_button('fields', $field) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-4">
                            <strong>Name</strong><br>
                            {{ !empty($field->name) ? $field->name : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Element</strong><br>
                            {{ !empty($field->element) ? ucwords($field->element) : '-' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Created By</strong><br>
                            {{ isset($field->created_by_user) && !empty($field->created_by_user) ? $field->created_by_user->name : 'System' }}
                        </div>
                        <div class="col-md-3 mb-4">
                            <strong>Updated By</strong><br>
                            {{ isset($field->updated_by_user) && !empty($field->updated_by_user) ? $field->updated_by_user->name : 'System' }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Description</strong><br>
                            {!! !empty($field->description) ? $field->description : '-' !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mb-5">
                            <strong>Options</strong><br>
                            @if(!empty($field->options) && count($field->options) > 0)
                                @foreach($field->options as $option)
                                    <span> - {{ $option->text ?? '' }}</span><br>
                                @endforeach
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
