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

            <form action="{{ route('assets.allocation.store') }}" method="post"
                  enctype="multipart/form-data" class="allocation_form" id="allocation_form">
                {{ csrf_field() }}

                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap py-3">
                        <div class="card-title">
                            <h3 class="card-label">Allocations</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label" for="user_id">User</label>
                                    <select name="user_id" id="user_id" class="form-control">
                                        <option value="">Please select a value</option>
                                        @foreach(\App\Providers\FormList::getUsers() as $key => $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label" for="asset_ids">Assets</label>
                                    <select name="asset_ids[]" id="asset_ids" class="form-control" multiple>
                                        <option value="">Please select a value</option>
                                        @foreach(\App\Providers\FormList::getAssets() as $asset)
                                            <option value="{{ $asset->id }}"
                                            >{{ $asset->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer py-5">
                        <button type="submit" class="btn btn-outline-primary font-weight-bold font-size-lg submit_button">
                            Allocate
                        </button>
                    </div>
                </div>

            </form>

            <div class="allocation_container">

            </div>
        </div>
    </div>
@stop

@section('page_js')
    <script type="text/javascript">
        $(document).ready(function () {
            init_select2();

            let user_id = $(document).find('select[name="user_id"]').val();
            if (user_id !== '') {
                get_allocated_items_by_user(user_id);
            }

            $(document).off('change', 'select[name="user_id"]');
            $(document).on('change', 'select[name="user_id"]', function () {
                let $this = $(this);
                if ($this.val() === '') {
                    $(document).find('.allocation_container').html('');
                    return false;
                }

                get_allocated_items_by_user($this.val());
            });
        });

        function init_select2() {
            $(document).find('select[name="user_id"], select[name="asset_ids[]"]').select2({
                placeholder: 'Please select a value',
                allowClear: true
            });
        }

        function get_allocated_items_by_user(user_id) {
            $.ajax({
                type: 'get',
                url: "{{ route('assets.allocation.items') }}",
                data: {
                    user_id: user_id
                },
                success: function (response) {
                    if (!response.success) {
                        $(document).find('.allocation_container').html('');
                        return false;
                    }

                    $(document).find('.allocation_container').html(response.data.html);
                    init_select2();
                }
            });
        }
    </script>
@stop
