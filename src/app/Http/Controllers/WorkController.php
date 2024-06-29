<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Breaking;
use App\Models\User;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('work', compact('user'));
    }

    public function store(Request $request)
    {
        if ($request->has('work_start')) {
            $work_start = new
                Carbon($request->input('work_start'));
        }
        if ($request->has('work_end')) {
            $work_end = new
                Carbon($request->input('work_end'));
        }
        if ($request->has('start_time')) {
            $start_time = new
                Carbon($request->input('start_time'));
        }
        if ($request->has('end_time')) {
            $end_time = new
                Carbon($request->input('end_time'));
        }

        Work::create(
            $request->only([
                'user_name',
                // 'work_date',
                'work_start',
                'work_end',
                // 'work_time',
                // 'breaking_time',
            ])
        );
        Breaking::create(
            $request->only([
                'breaking_start',
                'breaking_end'
            ])
        );

        /*
        $request['breaking_time'] = $request->breaking_end - $request->breaking_start;

        if文がいる？

        $request['work_time'] = $request->work_end - $request->work_start - $request->breaking_time;

        ・複数回の休憩時間の合計を計算する
        ・勤務終了ボタンを押したときに/attendaceに遷移するべき？
        Work::create(
            $request->only([
                'user_id',
                'work_date',
                'work_start',
                'work_end',
                'breaking_time',
                'work_time'
            ])
            );*/
        return redirect('/');
    }

    /*
    public function search(Request $request)
    {
        $works = Work::with('breaking')->DateSearch($request->work_date)->pagenate(5);
        $breakings = Breaking::all();

        return view('attendance', compact('works', 'breakings'));
    }*/
}
