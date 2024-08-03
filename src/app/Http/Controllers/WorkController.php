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

    public function newRecordAtMidnight(){
        $user = Auth::user();
        $now = Carbon::now();
        $yesterday = $now->copy()->subDay()->format('Y-m-d');
        $breaking = Breaking::whereDate('created_at', $yesterday)->get();
        $work = Work::whereDate('created_at', $yesterday)->whereNull('work_end')->first();

        if($now->format('H:i:s') === '00:00:00'){
            $allBreakingTime = $breaking->sum('breaking_time');
            $workTime = $work->work_end - $work->work_start - $allBreakingTime;
                
            $work->update([
                'work_end' => '23:59:59',
                'allbreaking_time' => $allBreakingTime,
                'work_time' => $workTime
            ]);

            Work::create([
                'user_id' => $user->id,
                'work_date' => $now->format('Y_m_d'),
                'work_start' => $now->secondsSinceMidnight()
            ]);
        } 
    }

    public function index()
    {
        $user = Auth::user();
        $newWork = Work::where('user_id', $user->id)->orderBy('created_at', 'desc')->first();
        $newBreaking = Breaking::where('work_id', $newWork->id)->orderBy('created_at', 'desc')->first();

        $isWorkStartDisabled = $newWork && $newWork->work_start !== null && $newWork->work_end === null;
        $isWorkEndDisabled = !$isWorkStartDisabled || ($newWork && $newWork->work_end !== null);
        $isBreakingStartDisabled = !$isWorkStartDisabled || ($newBreaking && $newBreaking->breaking_start !== null && $newBreaking->breaking_end === null);
        $isBreakingEndDisabled = !$isWorkStartDisabled || !$isBreakingStartDisabled;
        return view('work', compact('user', 'isWorkStartDisabled', 'isWorkEndDisabled', 'isBreakingStartDisabled', 'isBreakingEndDisabled'));
    }

    public function workStart()
    {
        $user = Auth::user();
        $now = Carbon::now();

        Work::create([
            'user_id' => $user->id,
            'work_date' => $now->format('Y_m_d'),
            'work_start' => $now->secondsSinceMidnight()
        ]);
        return redirect('/');
    }

    public function workEnd()
    {
        $userId = Auth::id();
        $now = Carbon::now();

        $work = Work::where('user_id', $userId)->orderBy('created_at', 'desc')->first();

        $breaking = Breaking::where('work_id', $work->id)->get();

        $allBreakingTime = $breaking->sum('breaking_time');
        $work_time = $work->work_end - $work->work_start - $allBreakingTime;
        $work->update([
            'work_end' => $now->secondsSinceMidnight(),
            'allbreaking_time' => $allBreakingTime,
            'work_time' => $work_time
        ]);
        
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
            'breaking_start' => $now->secondsSinceMidnight()
        ]);
        return redirect('/');
    }

    public function breakingEnd()
    {
        $userId = Auth::id();
        $work = Work::where('user_id', $userId)->orderBy('created_at', 'desc')->first();
        $now = Carbon::now();
        $lastBreaking = Breaking::where('work_id', $work->id)->whereNull('breaking_end')->first();

        if ($lastBreaking->breaking_start !== Carbon::parse('00:00:00')->secondsSinceMidnight() && is_null($lastBreaking->breaking_time)) {
            $breakingTime = $now->secondsSinceMidnight() - $lastBreaking->breaking_start;
            $lastBreaking->update([
                'breaking_end' => $now->secondsSinceMidnight(),
                'breaking_time' => $breakingTime
            ]);
        } else {
            Breaking::create([
                'work_id' => $work->id,
                'breaking_start' => Carbon::parse('00:00:00')->secondsSinceMidnight(),
                'breaking_end'
                => $now->secondsSinceMidnight(),
                'breaking_time' => $now->secondsSinceMidnight()
            ]);
        }
        return redirect('/');
    }

    public function search()
    {
        $today = Carbon::today();
        $works = Work::whereDate('created_at', $today)->with('user')->paginate(5);

        foreach ($works as $work) {
            $work->work_start = gmdate('H:i:s', $work->work_start);
            $work->work_end = gmdate('H:i:s', $work->work_end);
            $work->allbreaking_time = gmdate('H:i:s', $work->allbreaking_time);
            $work->work_time = gmdate('H:i:s', $work->work_time);
        }

        return view('attendance', compact('works', 'today'));
    }
}
