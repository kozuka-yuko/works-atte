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
        ・複数回の休憩時間の合計を計算する
        ・勤務終了ボタンを押したときに/attendaceに遷移するべき？
        */

    public function workStart()
    {
        $user = Auth::user();
        $now = Carbon::now();
        Work::create([
            'user_id' => $user->id,
            'work_date' => $now->toDateString(),
            'work_start' => $now->toTimeString()
        ]);
        return redirect('/');
    }

    public function workEnd()
    {
        $userId = Auth::id();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->toTimeString();
        $work = Work::firstOrNew(['user_id' => $userId, 'work_date' => $today]);
        $work->work_end = $now;
        $work->save();
        return redirect('/');
    }

    public function breakingStart()
    {
        $userId = Auth::id();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->toTimeString();
        $work = Work::where('user_id', $userId)
            ->where('work_date', $today)
            ->first();
        Breaking::create([
            'work_id' => $work->id,
            'breaking_start' => $now,
        ]);
        return redirect('/');
    }

    public function breakingEnd()
    {
        $userId = Auth::id();
        $today = Carbon::now()->toDateString();
        $now = Carbon::now()->toTimeString();
        $lastBreaking = Breaking::whereHas('work',function($query)use($userId,$today){
            $query->where('user_id',$userId)
            ->where('work_date',$today);
        })->orderBy('created_at', 'desc')->first();
        $lastBreaking->breaking_end = $now;
        $lastBreaking->save();
        return redirect('/');
    }

    public function search(Request $request)
    {
        $works = Work::with('breaking')->DateSearch($request->work_date)->pagenate(5);
        $breakings = Breaking::all();

        return view('attendance', compact('works', 'breakings'));
    }
}

// $request['work_time'] = $request->work_end - $request->work_start - $request->breaking_time;'work_time',