<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Attendance;
use App\Models\User;

class CalendarController extends Controller
{
    public function show_calendar()
    {
        $holidays = Holiday::all();
        $attendances = Attendance::with('user')->get();

            $transformed_holidays = $holidays->map(function ($holiday) {
                return [
                    'id'        => $holiday->id,
                    'title'     => $holiday->title,
                    'start'     => $holiday->start_date,
                    'end'       => Carbon::parse($holiday->end_date)->addDay()->format('Y-m-d') ,
                    'className' => 'fc-event-solid-success',
                    'extraInfo' => [
                            'description' => $holiday->description,
                        ]
                    ];
            });

            $transformed_attendances = $attendances->map(function ($attendance) {
                $class_name = ($attendance->type === 'absent') ? 'fc-event-solid-danger' 
                : (($attendance->shift === 'First-half') ? 'fc-event-solid-primary' 
                : (($attendance->shift === 'Second-half') ? 'fc-event-solid-info' 
                : 'fc-event-solid-warning'));
                    return [
                        'id' => $attendance->id,    
                        'title' => $attendance->user->name ,
                        'start' => $attendance->start_date,
                        'end' => Carbon::parse($attendance->end_date)->addDay()->format('Y-m-d'),
                        'className' => $class_name,
                        'extraInfo' => 
                            [
                                'type' => $attendance->type,
                                'reason' => $attendance->reason,
                                'user_id' => $attendance->user_id,
                                'shift' => $attendance->shift,
                            ]
                    ];
                });
        $all_events = $transformed_holidays->concat($transformed_attendances);        
        return view("calendar.calendar", compact("all_events"));        
    }

    public function add_holiday(Request $request)
    {
        DB::beginTransaction(); 
        try {
            $validator = Validator::make($request->all(), array(
                'title'       => 'required',
                'start_date'  => 'required',
                'end_date' => 'required|date|after_or_equal:start_date',
                'description' => 'required',
            ));
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $holiday = Holiday::create($request->all());
            DB::commit();
            return response()->json(['message' => 'Holiday updated successfully', 'holiday' => $holiday,], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit_holiday(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'title'       => 'required',
                'start_date'  => 'required',
                'end_date'    => 'required|date|after_or_equal:start_date',
                'description' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $holiday = Holiday::findOrFail($request->id);
            $holiday->update($request->all());

            DB::commit();
            return response()->json([
                'message' => 'Holiday updated successfully','holiday' => $holiday,], 200);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function delete_holiday(Request $request)
    {
        try {
            DB::beginTransaction(); 
            $holiday = Holiday::findOrFail($request->id);
            $holiday->delete();
            DB::commit(); 
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function add_attendance(Request $request)
    {
        DB::beginTransaction(); 
        try {
            $validator = Validator::make($request->all(), array(
                'user_id'    => 'required',
                'type'       => 'required',
                'start_date' => 'required',
                'end_date'   => 'required|date|after_or_equal:start_date',
                'shift'      => 'required',
                'reason'     => 'required',
            ));
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $attendance = Attendance::create($request->all());
            $user_name = $attendance->user->name;
            DB::commit();
            return response()->json(['message' => 'Successfully Added', 'attendance' => $attendance , 'user_name' => $user_name], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function edit_attendance(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id'    => 'required',
                'type'       => 'required',
                'start_date' => 'required',
                'end_date'   => 'required|date|after_or_equal:start_date',
                'shift'      => 'required',
                'reason'     => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $attendance = Attendance::findOrFail($request->id);
            $attendance->update($request->all());
            $user_name = $attendance->user->name;
            
            DB::commit();
            return response()->json([
                'message' => 'Attendance updated successfully', 'attendance' => $attendance,'user_name' => $user_name], 200);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function delete_attendance(Request $request)
    {
        try {
            DB::beginTransaction(); 
            $attendance = Attendance::findOrFail($request->id);
            $attendance->delete();
            DB::commit(); 
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
