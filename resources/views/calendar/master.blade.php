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
                            <a href="#" id="add_holiday_button" class="btn btn-light-primary font-weight-bold mr-2">
                                <i class="ki ki-plus"></i> Add Holiday
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
@stop    


@section('page_js')
    <script type="text/javascript">

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{csrf_token()}}"
        }
    });
    var events = @json($transformed_holidays);
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
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },

                    height: 800,
                    contentHeight: 780,
                    aspectRatio: 3,  

                    nowIndicator: true,
                    now: TODAY + 'T09:25:00', 

                    views: {
                        dayGridMonth: { buttonText: 'month' },
                        timeGridWeek: { buttonText: 'week' },
                        timeGridDay: { buttonText: 'day'}
                    },

                    defaultView: 'dayGridMonth',
                    defaultDate: TODAY,
                    eventLimit: true,
                    navLinks: true,
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
                            }
                );
            }
        };
    }();

    jQuery(document).ready(function() {
        KTCalendarBasic.init();
    });

    $('#add_holiday_button').on('click', function() {
        $('#add_holiday_modal').modal('show');
    });

     //Show Event Modal
     function show_event_modal(event, calendar)
    {
        $('#event_title').text(event.title);
        $('#event_start').text(moment(event.start).format('YYYY-MM-DD'));
        $('#event_end').text(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD'));
        $('#event_description').text(event._def.extendedProps.extraInfo.description);
        $('#event_modal').modal('show');
        $('#edit_event_btn').off('click').on('click', function() {
            if(event.classNames[0] === 'fc-event-solid-success')
                {
                    edit_holiday(event, calendar);
                }
            else{
                    edit_absent_leave(event,calendar);
                }
            });
        $('#delete_event_btn').off('click').on('click', function() {
                delete_event(event, calendar);
        });
    }

    //Save holiday
    $('#save_holiday_button').on('click', function() {
        var form_data = $('#add_holiday_form').serialize();
            $.ajax({
                url: "{{ route('calendar.add_holiday') }}",
                type: "POST",
                data: form_data,
                success: function(response) {
                    $('#add_holiday_modal').modal('hide');
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
                    var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#add_holiday_modal').find('[name="' + key + '"]').addClass('is-invalid'); 
                            $('#add_holiday_modal').find('[name="' + key + '"]').siblings('.invalid-feedback').remove(); 
                            $('#add_holiday_modal').find('[name="' + key + '"]').after('<div class="invalid-feedback">' + value[0] + '</div>'); 
                        });
                }
            });
    });
    
    //Edit holiday
    function edit_holiday(event, calendar) {
        $('#edit_holiday_id').val(event.id);
        $('#edit_holiday_name').val(event.title);
        $('#edit_start_date').val(moment(event.start).format('YYYY-MM-DD'));
        $('#edit_end_date').val(moment(event.end).subtract(1, 'days').format('YYYY-MM-DD'));
        $('#edit_holiday_description').val(event._def.extendedProps.extraInfo.description);
        $('#edit_holiday_modal').modal('show');
        $('#edit_holiday_button').off('click').on('click', function(events) {
            events.preventDefault();
            var form_data = $('#edit_holiday_form').serialize();
            var is_valid = true;
            $('#edit_holiday_form .form-control[required]').each(function() {
                if ($(this).val() === '') {
                    is_valid = false;
                    $(this).addClass('is-invalid');
                    $(this).next('.invalid-feedback').show();
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').hide();
                }
            });
            if (!is_valid) {
                return;
            }
            $.ajax({
                url: '{{ route('edit.holiday') }}',
                method: 'POST',
                data: form_data,
                success: function(response) {
                    $('#edit_holiday_modal').modal('hide');
                    $('#event_modal').modal('hide');
                    $('#edit_holiday_form').trigger('reset');
                    var calendar_event = calendar.getEventById(response.holiday.id);
                    var newEndDate = moment(response.holiday.end_date).add(1, 'day').toDate();
                        calendar_event.setProp('title', response.holiday.title);
                        calendar_event.setDates(response.holiday.start_date, newEndDate);
                        calendar_event.setExtendedProp('description', response.holiday.description);
                    Swal.fire(
                            'Updated!',
                            'Your event has been updated.',
                            'success'
                    );     
                },
                error: function(xhr, status, error) {
                    Swal.fire(
                        'Error!',
                        'Failed to update the event.',
                        'error'
                    );
                }
            });
        });
    }

    //Delete function
    function delete_event(event, calendar) {
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

    //Date pickers

        $('#kt_start_date').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
            });
        $('#kt_end_date').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
            });
        $('#edit_start_date').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
                autoclose : true
                
            });
        $('#edit_end_date').datepicker({
                rtl: KTUtil.isRTL(),
                todayHighlight: true,
                orientation: "bottom left",
                format: 'yyyy-mm-dd',
                autoclose: true
            
            });

    </script>
@stop
