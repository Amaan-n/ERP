<?php

namespace App\Http\Controllers;

use \Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsController extends Controller
{
    public function index(Request $request)
    {
        $date_range = $request->has('date_range') ? $request->get('date_range') :  Carbon::now()->format('m/d/Y') . ' - ' . Carbon::now()->format('m/d/Y');
        $dates = explode(' - ', $date_range);
        $start_date   = Carbon::parse($dates[0])->format('Y-m-d 00:00:00');
        $end_date     = Carbon::parse($dates[1])->format('Y-m-d 23:59:59');
            
        $model_name = $request->input('model_name');
        $activity_logs = Activity::when(!is_null($model_name) && !empty($model_name), function ($query) use ($model_name) {
            $model_name = ucfirst(strtolower($model_name));
            $model_name = 'App\\Models\\' . $model_name;
            return $query->where('subject_type', $model_name);
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->orderBy('created_at', 'desc')
        ->get();
        // dd( $activity_logs) ;
        return view('activity_logs.activity_logs', ['activity_logs' => $activity_logs]);
    }   
}
