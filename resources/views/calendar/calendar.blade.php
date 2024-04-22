@extends('layouts.master')
@section('content')
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card card-custom gutter-b">
                <div class="card-header flex-wrap py-3">
                    <div class="card-title">
                      <h2>  Calendar  </h2>
                    </div>
                    @if($is_root_user == 1)
                        <div class="card-toolbar">
                            <a href="javascript:void(0);" id="add_holiday_button" class="btn btn-light-primary font-weight-bold mr-2">
                                <i class="ki ki-plus"></i> Add Holiday
                            </a>
                            <a href="javascript:void(0);" id="add_attendance_button" class="btn btn-light-primary font-weight-bold mr-2">
                                <i class="ki ki-plus"></i> Apply Absent and Leave
                            </a>
                        </div>
                    @else
                        <div class="card-toolbar">
                            <a href="javascript:void(0);"  id="add_attendance_button" class="btn btn-light-primary font-weight-bold">
                                <i class="ki ki-plus"></i> Apply Leave 
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                        <div id="kt_calendar"></div>
                </div>
	        </div>
        </div>    
    </div>
    @include('modals.calendar.show_event_info')
    @include('modals.calendar.holidays.add_holiday')
    @include('modals.calendar.holidays.edit_holiday')
    @include('modals.calendar.attendance.add_attendance')
    @include('modals.calendar.attendance.edit_attendance')
@stop    


@section('page_js')
    @php
        $logged_in_user_id = Auth::user()->id;
    @endphp
    <script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
    });
    
    var events = @json($all_events);
    console.log(events);
    var logged_in_user_id = {{ $logged_in_user_id }};
    
    var KTCalendarBasic = function() 
    {
        return {
            init: function() {
                var todayDate = moment().startOf('day');
                var YM = todayDate.format('YYYY-MM');
                var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
                var TODAY = todayDate.format('YYYY-MM-DD');
                var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

                var calendarEl = document.getElementById('kt_calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
                    themeSystem: 'bootstrap',

                    isRTL: KTUtil.isRTL(),
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                      
                    },
                    
                    height: 800,
                    contentHeight: 780,
                    aspectRatio: 3,  

                    nowIndicator: true,
                    now: TODAY + 'T09:25:00', 

                    views: {
                        dayGridMonth: { buttonText: 'month' },
                    },

                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,
                    eventLimit: true,
                    navLinks: false,
                    displayEventTime: false,
                    events: events,

                    eventRender: function(info) 
                            {
                                var event_element = info.el;
                                event_element.addEventListener('click', function() {
                                        show_event_modal(info.event, calendar);
                                });
                            }    
                });

                calendar.render();

                $(document).on('refresh_calendar_events', function(event, event_data) {
                        if (event_data.holiday) {
                            var existingEvent = calendar.getEventById(event_data.holiday.id);
                                if (existingEvent) {
                                    existingEvent.remove();
                                }
                            calendar.addEvent({
                                id: event_data.holiday.id,
                                title: event_data.holiday.title,
                                start: event_data.holiday.start_date,
                                end: moment(event_data.holiday.end_date).add(1, 'day').toDate(),
                                className: 'fc-event-solid-success',
                                extraInfo: {
                                    description: event_data.holiday.description
                                }
                            });
                        } else if (event_data.attendance) {
                            var class_name = (event_data.attendance.type === 'absent') ? 'fc-event-solid-danger' 
                            : (event_data.attendance.shift === 'First-half') ? 'fc-event-solid-primary' 
                            : (event_data.attendance.shift === 'Second-half') ? 'fc-event-solid-info' 
                            : 'fc-event-solid-warning';
                            var existingEvent = calendar.getEventById(event_data.attendance.id);
                                if (existingEvent) {
                                    existingEvent.remove();
                                }
                            calendar.addEvent({
                                id: event_data.attendance.id,
                                title: event_data.user_name,
                                start: event_data.attendance.start_date,
                                end: moment(event_data.attendance.end_date).add(1, 'day').toDate(),
                                className: class_name,
                                extraInfo: {
                                    shift   : event_data.attendance.shift,
                                    type    : event_data.attendance.type,
                                    reason  : event_data.attendance.reason, 
                                    user_id : event_data.attendance.user_id,
                                }
                            });
                        }
                    });

            }
        };
    }();

    jQuery(document).ready(function() {
        KTCalendarBasic.init();
    });

    $('#add_holiday_button').on('click', function() {
        $('#add_holiday_modal').modal('show');
    });

    $('#add_attendance_button').on('click', function() {
        $('#add_attendance_modal').modal('show');
    });

     //////////////============Show Event Modal===============/////////////////
     function show_event_modal(event, calendar)
    {
        var extraInfo = event._def.extendedProps.extraInfo;
        $('#event_title').text(event.title);
        $('#event_start').text(moment(event.start).format('YYYY-MM-DD'));
        $('#event_end').text(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD'));
        $('#event_description').text(extraInfo.description || extraInfo.reason || '');
        $('#event_shift').text(extraInfo.shift ? extraInfo.shift.toUpperCase() : "Full DAY"); 
        $('#event_type').text( extraInfo.type ? extraInfo.type.toUpperCase() : 'HOLIDAY');
        $('#event_modal').modal('show');

        if (logged_in_user_id == extraInfo.user_id && extraInfo.type !== "absent") {
            $('#edit_delete_buttons').html(`
                <button type="button" class="btn btn-warning mr-2" id="edit_event_btn">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-danger" id="delete_event_btn">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `);
        } else {
            $('#edit_delete_buttons').empty();
        }

        $('#edit_event_btn').off('click').on('click', function() {
            if(event.classNames[0] === 'fc-event-solid-success')
                {
                    edit_holiday(event, calendar);
                }
            else{
                    edit_attendance(event,calendar);
                }
            });

        $('#delete_event_btn').off('click').on('click', function() {
            if(event.classNames[0] === 'fc-event-solid-success')
                {
                    delete_event_holiday(event, calendar);
                }
            else{
                   delete_event_attendance(event, calendar);
                }
            });
                
        
    }

   ///////============Saving Attendance==============//////////////
   
   $('#save_attendance_button').on('click',function(){
    var form_data = $('#add_attendance_form').serialize();
        $.ajax({
            url : "{{route('add.attendance')}}",
            type : "POST",
            data : form_data,
            success: function(response) {
                   $('.invalid-feedback').hide().text('');
                    $('#add_attendance_modal').modal('hide');
                    Swal.fire({
                    title: "Success!",
                    text:  "Saved successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-primary" }
                        }).then((result) => {
                            $(document).trigger('refresh_calendar_events', [response]);
                            $('#add_attendance_form').trigger('reset');
                            });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        display_errors(xhr.responseJSON.errors);
                    } else {
                        
                        Swal.fire('Error!', 'Failed to Create Record.', 'error');
                    }
                }
        })
   })

   ///////////////==============Editing Attendance==================/////////////////

   function edit_attendance(event, calendar) {
        $('#edit_attendance_id').val(event.id);
        $('#edit_attendance_user_id').val(event._def.extendedProps.extraInfo.user_id);
        $('#edit_attendance_start_date').val(moment(event.start).format('YYYY-MM-DD'));
        $('#edit_attendance_end_date').val(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD'));
        $('#edit_attendance_type').val(event._def.extendedProps.extraInfo.type);
        $('#edit_attendance_shift').val(event._def.extendedProps.extraInfo.shift);
        $('#edit_attendance_reason').val(event._def.extendedProps.extraInfo.reason);
        $('#edit_attendance_modal').modal('show');
        $('#edit_attendance_button').off('click').on('click', function(events) {
            events.preventDefault();
            var form_data = $('#edit_attendance_form').serialize();
            $.ajax({
                url: '{{ route('edit.attendance') }}',
                method: 'POST',
                data: form_data,
                success: function(response) {
                        $('#edit_attendance_modal').modal('hide');
                        $('#event_modal').modal('hide');
                        $('#edit_attendance_form').trigger('reset');
                        $('.invalid-feedback').hide().text('');
                        $(document).trigger('refresh_calendar_events', [response]);
                        Swal.fire('Updated!', 'Your Record has been updated.', 'success');
                    }
                ,
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        display_errors(xhr.responseJSON.errors);
                    } else {
                        
                        Swal.fire('Error!', 'Failed to update the Record.', 'error');
                    }
                }
            });
        });
    }

   /////////////=============Deleting Attendance================/////////////

   function delete_event_attendance(event, calendar) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this event!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('delete.attendance') }}',
                    type: 'DELETE',
                    data: {
                        id: event.id
                    },
                    success: function(response) {
                        $('#event_modal').modal('hide');
                        calendar.getEventById(event.id).remove();
                        Swal.fire(
                            'Deleted!',
                            'Your Record has been deleted.',
                            'success'
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Failed to delete the Record.',
                            'error'
                        );
                    }
                });
            }
        });
    }

   ////////////////////===============Holidays Module==========/////////////////////

    ////======Saving holiday======//////

    $('#save_holiday_button').on('click', function() {
        var form_data = $('#add_holiday_form').serialize();
            $.ajax({
                url: "{{ route('add.holiday') }}",
                type: "POST",
                data: form_data,
                success: function(response) {
                    $('#add_holiday_modal').modal('hide');
                    $('.invalid-feedback').hide().text('');
                    Swal.fire({
                    title: "Success!",
                    text: "Holiday saved successfully!",
                    icon: "success",
                    buttonsStyling: false,
                    confirmButtonText: "OK",
                    customClass: { confirmButton: "btn btn-primary" }
                        }).then((result) => {
                            $(document).trigger('refresh_calendar_events', [response]);
                            $('#add_holiday_form').trigger('reset');
                            });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        display_errors(xhr.responseJSON.errors);
                    } else {
                        
                        Swal.fire('Error!', 'Failed to Create Record.', 'error');
                    }
                }
            });
    });
    
    //////////========Editing holiday=========////////////

    function edit_holiday(event, calendar) {
        $('#edit_holiday_id').val(event.id);
        $('#edit_holiday_name').val(event.title);
        $('#edit_holiday_start_date').val(moment(event.start).format('YYYY-MM-DD'));
        $('#edit_holiday_end_date').val(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD'));
        $('#edit_holiday_description').val(event._def.extendedProps.extraInfo.description);
        $('#edit_holiday_modal').modal('show');
        $('#edit_holiday_button').off('click').on('click', function(events) {
            events.preventDefault();
            var form_data = $('#edit_holiday_form').serialize();
            $.ajax({
                url: '{{ route('edit.holiday') }}',
                method: 'POST',
                data: form_data,
                success: function(response) {
                    $('#edit_holiday_modal').modal('hide');
                    $('#event_modal').modal('hide');
                    $('#edit_holiday_form').trigger('reset');
                    $('.invalid-feedback').hide().text(''); 
                    $(document).trigger('refresh_calendar_events', [response]);
                    Swal.fire(
                            'Updated!',
                            'Your event has been updated.',
                            'success'
                    );     
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        display_errors(xhr.responseJSON.errors);
                    } else {
                        
                        Swal.fire('Error!', 'Failed to update the Record.', 'error');
                    }
                }
            });
        });
    }

    ///////////=============Deleting holiday==========//////////

    function delete_event_holiday(event, calendar) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this event!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('delete.holiday') }}',
                    type: 'DELETE',
                    data: {
                        id: event.id
                    },
                    success: function(response) {
                        $('#event_modal').modal('hide');
                        calendar.getEventById(event.id).remove();
                        Swal.fire(
                            'Deleted!',
                            'Your event has been deleted.',
                            'success'
                        );
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        Swal.fire(
                            'Error!',
                            'Failed to delete the event.',
                            'error'
                        );
                    }
                });
            }
        });
    }

   //Function for displaying server-side validation Errors

    function display_errors(errors) {
        $('.invalid-feedback').hide().text(''); 
        $.each(errors, function(key, value) {
            var errorElement = $('[name="' + key + '"]').next('.invalid-feedback');
            errorElement.text(value[0]).show(); 
        });
    }

    /////===Date picker====/////
        $('.datepicker').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
            }); 

    </script>
@stop
