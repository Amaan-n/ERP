@extends('layouts.master')

@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(\Illuminate\Support\Facades\Session::has('notification'))
                        <div class="alert alert-{{\Illuminate\Support\Facades\Session::get('notification.type')}}">
                            <span><?php echo \Illuminate\Support\Facades\Session::get('notification.message'); ?></span>
                        </div>
                    @endif
                </div>
            </div>

            <!--begin::Card-->
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                        <h3 class="card-label">List Of Tags</h3>
                    </div>
                    <div class="card-toolbar">
                        {!! prepare_header_html('tags', 'listing') !!}
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered data_table">
                        <thead>
                        <tr>
                            <th>Index</th>
                            <th>Asset</th>
                            <th>Value</th>
                            <th>Tags</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tags as $index => $tag)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ isset($tag->mapping->asset->name) && !empty($tag->mapping->asset->name) ? $tag->mapping->asset->name : '-' }}</td>
                                <td>{{ !empty($tag->value) ? $tag->value : '-' }}</td>
                                <td>
                                    <a href="{{ config('constants.s3.asset_url') . $tag->attachment }}" target="_blank">
                                        Show QR
                                    </a>
                                </td>
                                <td>{{ !empty($tag->created_at) ? \Carbon\Carbon::createFromTimestamp(strtotime($tag->created_at))->format('dS F, Y') : '-' }}</td>
                                <td nowrap="nowrap">{!! prepare_listing_action_buttons('tags', $tag, $accesses_urls) !!}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
