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
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
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
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'description' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            DB::beginTransaction(); 
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
}
