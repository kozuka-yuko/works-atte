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
        $today = Carbon::today();
        $newWork = Work::where('user_id', $user->id)->whereDate('created_at', $today)->orderBy('created_at', 'desc')->first();
        $newBreaking = Breaking::where('work_id', $newWork->id)->whereDate('created_at', $today)->orderBy('created_at', 'desc')->first();

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

        if ($work->work_start !== Carbon::parse('00:00:00')->secondsSinceMidnight()) {
            $work->update(['work_end' => $now->secondsSinceMidnight()]);
        } else {
            $work->update(['work_end' => Carbon::parse('23:59:59')->secondsSinceMidnight()]);
            $newWork = Work::create([
                'user_id' => $userId,
                'work_date' => $now->format('Y_m_d'),
                'work_start' => Carbon::parse('00:00:00')->secondsSinceMidnight(),
                'work_end' => $now->secondsSinceMidnight()
            ]);
        }

        $breaking = Breaking::where('work_id', $work->id)->get();
        $newBreaking = Breaking::where('work_id', $work->id + 1)->get();

        if ($work->work_start !== Carbon::parse('00:00:00')->secondsSinceMidnight()) {
            $allBreakingTime = $breaking->sum('breaking_time');
            $work_time = $work->work_end - $work->work_start - $allBreakingTime;
            $work->update([
                'allbreaking_time' => $allBreakingTime,
                'work_time' => $work_time
            ]);
        } else {
            $y_allBreakingTime = $breaking->sum('breaking_time');
            $y_workTime = $work->work_end - $work->work_start - $y_allBreakingTime;
            $work->update([
                'allbreaking_time' => $y_allBreakingTime,
                'work_time' => $y_workTime
            ]);

            $t_allBreakingTime = $newBreaking->sum('breaking_time');
            $t_workTime = $newWork->work_end - $t_allBreakingTime;
            $newWork->update([
                'allbreaking_time' => $t_allBreakingTime,
                'work_time' => $t_workTime
            ]);
        }
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
