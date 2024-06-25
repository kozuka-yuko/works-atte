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
        /*
        $request['breaking_time'] = $request->breaking_end - $request->breaking_start;
        $request['work_time'] = $request->work_end - $request->work_start;
        複数回の休憩時間の合計を計算する
        勤務時間は終了時間－開始時間－休憩時間
        ・勤務終了ボタンを押したときに/attendaceに遷移するべき？*/
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

    
    
    public function search(Request $request)
    {
        $works = Work::with('breaking')->DateSearch($request->work_date)->pagenate(5);
        $breakings = Breaking::all();
        
        return view('attendance', compact('works', 'breakings'));
    }
}