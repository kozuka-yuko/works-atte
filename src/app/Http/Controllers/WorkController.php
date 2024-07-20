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
        $work->update(['work_end' => $now]);
        return redirect('/');
    }

    public function breakingStart()
    {
        $userId = Auth::id();
        $now = Carbon::now()->toTimeString();

        $work = Work::where('user_id', $userId)
            ->orderBy('created_at', 'desc')->first();
        Breaking::create([
            'work_id' => $work->id,
            'breaking_start' => $now,
        ]);
        return redirect('/');
    }

    public function breakingEnd()
    {
        $userId = Auth::id();
        $work = Work::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
        $now = Carbon::now();

        $lastBreaking = Breaking::where('work_id', $work->id)->whereNull('breaking_end')->first();
        $lastBreaking->breaking_time = $now->diffInMinutes($lastBreaking->breaking_start);
        $hours = floor($lastBreaking->breaking_time / 60);
        $minutes = $lastBreaking->breaking_time % 60;
        $seconds = $now->diffInSeconds($lastBreaking->breaking_start) % 60;
        $lastBreaking->update([
            'breaking_end' => $now->toTimeString(),
            'breaking_time' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)
        ]);

        return redirect('/');
    }

    public function search()
    {
        $today = Carbon::today();
        $works = Work::whereDate('created_at', $today)->with('user')->paginate(5);

        return view('attendance', compact('works','today'));
    }
}
