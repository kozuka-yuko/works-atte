<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Breaking;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('work', compact('user'));
    }

    /*
        $request['breaking_time'] = $request->breaking_end - $request->breaking_start;

        if文がいる？

        $request['work_time'] = $request->work_end - $request->work_start - $request->breaking_time;

        ・複数回の休憩時間の合計を計算する
        ・勤務終了ボタンを押したときに/attendaceに遷移するべき？
        */

    public function workStart(Request $request)
    {
        $user = Auth::user();
        $now = Carbon::now();
        Work::create([
            'user_id' => $user->id,
            'work_date' => $now->format('n-d'),
            'work_start' => $now->format('H:i')
        ]);
        return redirect('/');
    }

    public function workEnd(Request $request)
    {
        $now = Carbon::now();
        Work::create([
            'work_end' => $now->format('H:i'),
            'work_time',
            'breaking_time',
        ]);
        return redirect('/');
    }

    public function breakingStart(Request $request)
    {
        $now = Carbon::now();
        $workId = $request->input('work_id');
        $work = Work::find($workId);
        Breaking::create([
            'work_id' => $work->id,
            'breaking_start' => $now->format('H:i'),
        ]);
        return redirect('/');
    }

    public function breakingEnd(Request $request)
    {
        $now = Carbon::now();
        Breaking::create([
            'breaking_end' => $now->format('H:i'),
        ]);
        return redirect('/');
    }

    public function search(Request $request)
    {
        $works = Work::with('breaking')->DateSearch($request->work_date)->pagenate(5);
        $breakings = Breaking::all();

        return view('attendance', compact('works', 'breakings'));
    }
}
// 名前の表示をするからusersもいる？
