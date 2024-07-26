<?php

namespace App\Http\Controllers;

require '../vendor/autoload.php';
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Work;
use App\Models\Breaking;
use Carbon\Carbon;

class WorkController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('work', compact('user'));
    }

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
        $now = Carbon::now();

        $work = Work::where('user_id',$userId)->orderBy('created_at', 'desc')->first();
        $yesterdayWork = Work::where('work_id',$work->work_id - 1);

        if($now->isSameDay(Carbon::parse($work->work_date))){
            $work->update(['work_end' => $now->toTimeString()]);
        }else{
            $yesterdayWork->update(['work_end' => '23:59:59']);
            $work = Work::create(['user_id'=> $userId,
            'work_date' => $now->toDateString(),
            'work_start'=>'00:00:00',
            'work_end'=>$now->toTimeString()]);}

        $todayBreakings = Breaking::where('work_id',$work->id)->get();
        $yesterdayBreakings =Breaking::where('work_id',$work->id-1)->get();
        
        if($work->work_start !== '00:00'){
            $allBreakingTime = $todayBreakings->sum('breaking_time');
        }else{
            $allBreakingTime = $yesterdayBreakings->sum('breaking_time');
        }
        dd($allBreakingTime);


        $work->update(['allbreaking_time' => $allBreakingTime]);
        return redirect('/');
    }

    public function breakingStart()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        $work = Work::where('user_id', $userId)
            ->orderBy('created_at', 'desc')->first();
        Breaking::create([
            'work_id' => $work->id,
            'breaking_start' => $now->toTimeString()
        ]);
        return redirect('/');
    }

    public function breakingEnd()
    {
        $userId = Auth::id();
        $work = Work::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
        $now = Carbon::now();
        $lastBreaking = Breaking::where('work_id', $work->id)->whereNull('breaking_end')->first();

        if ($lastBreaking && is_null($lastBreaking->breaking_time)) {
            $lastBreaking->breaking_time = $now->diffInMinutes($lastBreaking->breaking_start);
            $hours = floor($lastBreaking->breaking_time / 60);
            $minutes = $lastBreaking->breaking_time % 60;
            $seconds = $now->diffInSeconds($lastBreaking->breaking_start) % 60;

            $lastBreaking->update([
                'breaking_end' => $now->toTimeString(),
                'breaking_time' => sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds)
            ]);
        }

        return redirect('/');
    }

    public function search()
    {
        $today = Carbon::today();
        $works = Work::whereDate('created_at', $today)->with('user')->paginate(5);

        return view('attendance', compact('works', 'today'));
    }
}
