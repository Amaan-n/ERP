<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\Holiday;

class CalendarController extends Controller
{
    public function show_calendar()
    {
        $holidays = Holiday::all();
                $transformed_holidays = $holidays->map(function ($holiday) {
                    $end_date = Carbon::parse($holiday->end_date)->addDay()->format('Y-m-d');
                    return [
                        'id'        => $holiday->id,
                        'title'     => $holiday->title,
                        'start'     => $holiday->start_date,
                        'end'       => $end_date ,
                        'className' => 'fc-event-solid-success',
                        'extraInfo' => [
                            'description' => $holiday->description,
                        ]
                    ];
                });
        return view("calendar.master", compact("transformed_holidays"));        
    }

    public function add_holiday(Request $request)
    {
        DB::beginTransaction(); 
        try {
            $data = $request->all();
            $validator = Validator::make($data, array(
                'holiday_name' => 'required',
                'holiday_start_date' => 'required',
                'holiday_end_date' => 'required',
                'holiday_description' => 'required',
            ));
        
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            $holiday = new Holiday();
            $holiday->title = $request->holiday_name;
            $holiday->start_date = $request->holiday_start_date;
            $holiday->end_date = $request->holiday_end_date;
            $holiday->description = $request->holiday_description;
            $holiday->save();
            DB::commit();
            return response()->json(['message' => 'Holiday updated successfully',
                'id' => $holiday->id, 
                'title' => $holiday->title, 
                'start' => $holiday->start_date, 
                'end' => $holiday->end_date,
                'extraInfo' => [
                    'description' => $holiday->description,
                ]], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit_holiday(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'holiday_name' => 'required',
            'holiday_start_date' => 'required',
            'holiday_end_date' => 'required',
            'holiday_description' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        try {
            DB::beginTransaction(); 
            $holiday = Holiday::findOrFail($id);
            $holiday->title = $request->holiday_name;
            $holiday->start_date =  $request->holiday_start_date;
            $holiday->end_date = $request->holiday_end_date;
            $holiday->description = $request->input('holiday_description');
            $holiday->save();
            DB::commit();

            return response()->json(['message' => 'Event updated successfully',
             'id' => $holiday->id, 
             'title' => $holiday->title, 
             'start' => $holiday->start_date, 
             'end' => $holiday->end_date,
             'extraInfo' => [
                'description' => $holiday->description,
            ]], 200);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error is undefined' => $e->getMessage()], 500);
        }
    }
    public function delete_holiday($id)
    {
        try {
            DB::beginTransaction(); 
            $event = Holiday::findOrFail($id);
            $event->delete();
            DB::commit(); 
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback(); 
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
