<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Work;
use App\Models\Breaking;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        return view('work');
    }

    public function store(Request $request)
    {
        if($request->has('work_start')){
            $work_start = new Carbon();
        }
        if ($request->has('work_end')) {
            $work_end = new Carbon();
        }
        if ($request->has('start_time')) {
            $start_time = new Carbon();
        }
        if ($request->has('end_time')) {
            $end_time = new Carbon();
        }

        $request['breaking_time'] = $request->breaking_end - $request->breaking_start;
        $request['work_time'] = $request->work_end - $request->work_start;
        Work::create(
            $request->only([
                'user_id',
                'work_date',
                'work_start',
                'work_end',
                'breaking_time',
                'work_time'
            ])
            );
        return redirect('/'); 
    }
    
    
    public function getSearchQuery($request,$query)
    {
        if(!empty($request->date)){
            $query->whereDate('work_date','=',$request->date);
        }
        return $query;

        $works = Work::with('breaking')->pagenate(5);
        $breakings = Breaking::all();
        return view('attendance', compact('works', 'breakings'));
    }
}
