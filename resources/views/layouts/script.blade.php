<script>
    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
</script>

<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {"sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400},
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };</script>
<!--end::Global Config-->

<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('theme/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('theme/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('theme/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('theme/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/widgets.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('theme/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/datatables/basic/basic.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/editors/summernote.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/js/pages/crud/forms/widgets/select2.js') }}"></script>
<!--end::Page Scripts-->

<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('theme/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Scripts-->

<script src="{{ asset('theme/plugins/custom/lightbox/dist/js/lightbox.js') }}"></script>

<script src="{{ asset('js/jquery.validate.js') }}"></script>
<script src="{{ asset('js/additional-methods.js') }}"></script>

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    let isFormDirty = false;
    $('form').submit(function (event) {
        isFormDirty = false;
    });

    $('input, textarea, select').change(function () {
        isFormDirty = true;
    });

    $(window).bind('beforeunload', function () {
        if (isFormDirty) {
            return false;
        }
    });

    $(document).ready(function () {
        $(document).off('click', '.submit_button');
        $(document).on('click', '.submit_button', function (e) {
            e.preventDefault();
            $(this).attr('disabled', true);

            if (!$(this).closest('form').valid()) {
                $(this).removeAttr('disabled');
                return false;
            }

            $(this).closest('form').submit();
        });

        $(document).off('click', '.remove_attachment');
        $(document).on('click', '.remove_attachment', function (e) {
            e.preventDefault();
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((will_delete) => {
                if (will_delete) {
                    $_this.parents('.form-group').find('input[type="hidden"]').val('');
                    $_this.parents('.form-group').find('.input_action_buttons').remove();
                    $.ajax({
                        type: 'get',
                        url: "{{ route('remove.file') }}",
                        data: {
                            module: $_this.attr('data-module'),
                            field: $_this.attr('data-field'),
                            id: $_this.attr('data-id'),
                            attachment: $_this.attr('data-attachment'),
                        },
                        success: function (response) {
                            if (!response.success) {
                                swal('Error...', response.message, 'error')
                                return false;
                            }

                            if ($_this.attr('data-module') === 'attachments') {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    confirmButtonText: '<i class="fa fa-thumbs-up text-white mr-2"></i> Great!',
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                })
                            } else {
                                swal(response.message, {icon: "success", timer: 3000});
                            }
                        }
                    });
                }
            });
        });

        $(document).off('click', '.delete_item');
        $(document).on('click', '.delete_item', function () {
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((will_delete) => {
                    if (will_delete) {
                        // swal("Poof! Your item has been deleted!", {
                        //     icon: "success",
                        // });
                        setTimeout(function () {
                            $_this.parents('td').find('.delete_item_form').submit();
                            $_this.parents('span').find('.delete_item_form').submit();
                            $_this.parents('li').find('.delete_item_form').submit();
                        }, 1000);
                    } else {
                        // window.location.reload();
                    }
                });
        });

        $(document).off('click', '.update_state');
        $(document).on('click', '.update_state', function () {
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "You want to update the state!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((will_delete) => {
                    if (will_delete) {
                        $.ajax({
                            type: 'get',
                            url: "{{ route('state.update') }}",
                            data: {
                                module: $_this.attr('data-module'),
                                id: $_this.attr('data-id')
                            },
                            success: function (response) {
                                if (!response.success) {
                                    swal('Error...', response.message, 'error')
                                    return false;
                                }
                                $_this.find('i').removeAttr('class');
                                if (response.data !== undefined && response.data.is_active == 1) {
                                    $_this.find('i').attr('class', 'fa fa-check text-success');
                                } else {
                                    $_this.find('i').attr('class', 'fa fa-times text-danger');
                                }
                                swal(response.message, {icon: "success",});
                            }
                        });
                    } else {
                        // window.location.reload();
                    }
                });
        });

        init_data_table();

        $('.notes_form').validate({
            ignore: ':hidden',
            errorClass: "invalid",
            rules: {
                title: 'required',
                description: 'required'
            }
        });

        $(document).off('click', '.add_note');
        $(document).on('click', '.add_note', function () {
            $(document).find('.notes_modal').modal('show');

            let form_selector = $(document).find('.notes_modal').find('form');
            form_selector.find('input[name="id"]').val(0);
            form_selector.find('input[name="title"]').val('');
            form_selector.find('textarea[name="description"]').text('');
        });

        $(document).off('click', '.edit_note');
        $(document).on('click', '.edit_note', function () {
            $(document).find('.notes_modal').modal('show');

            let form_selector = $(document).find('.notes_modal').find('form');
            form_selector.find('input[name="id"]').val($(this).attr('data-note-id'));
            form_selector.find('input[name="title"]').val($(this).attr('data-title'));
            form_selector.find('textarea[name="description"]').text($(this).attr('data-description'));
        });

        $(document).off('click', '.delete_note');
        $(document).on('click', '.delete_note', function () {
            let $_this = $(this);
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this item!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((will_delete) => {
                    if (will_delete) {
                        $.ajax({
                            type: 'GET',
                            url: '{{ route('notes.destroy') }}/' + $_this.attr('data-note-id'),
                            success: function (response) {
                                if (!response.success) {
                                    swal('Error...', response.message, 'error')
                                    return false;
                                }

                                $(document).find('.notes_container').html(response.data.notes_container);
                            }
                        });
                    }
                });
        });

        $(document).off('click', '.note_submit');
        $(document).on('click', '.note_submit', function () {
            if (!$(document).find('.notes_form').valid()) {
                return false;
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ route('notes.store') }}',
                data: $(this).closest('form').serialize(),
                success: function (response) {
                    if (!response.success) {
                        swal('Error...', response.message, 'error')
                        return false;
                    }

                    $(document).find('.notes_container').html(response.data.notes_container);
                    $(document).find('.notes_form')[0].reset();
                    $(document).find('.notes_modal').modal('hide');
                }
            });
        });
    });

    function init_data_table() {
        $('.data_table').DataTable({
            responsive: true,
            filter: true,
            search: true,
            bSearch: true,
            dom: `<'row'<'col-sm-12'ftr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            lengthMenu: [10, 25, 50, 100],
            pageLength: 25,
            language: {
                'lengthMenu': 'Display _MENU_',
            },
            // order: [[0, 'desc']],
            order: []
        });
    }
</script>
