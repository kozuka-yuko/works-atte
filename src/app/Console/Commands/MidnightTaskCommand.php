<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Work;
use App\Models\Breaking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class MidnightTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:MidnightTask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute midnight tasks for user work records';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $users = User::all();
            $now = Carbon::now();
            $yesterday = $now->copy()->subDay()->format('Y-m-d');

            foreach ($users as $user) {
                $work = Work::where('user_id', $user->id)->whereDate('created_at', $yesterday)->whereNull('work_end')->first();

                if ($work) {
                    $work->update(['work_end' => $now->copy()->endOfDay()->secondsSinceMidnight()]);

                    $breakings = Breaking::where('work_id', $work->id)->whereDate('created_at', $yesterday)->get();
                    $lastbreaking = $breakings->whereNull('breaking_end')->first();

                    if ($lastbreaking) {
                        $lastbreaking->update([
                            'breaking_end' => $now->copy()->endOfDay()->secondsSinceMidnight(),
                            'breaking_time' => $lastbreaking->breaking_end - $lastbreaking->breaking_start
                        ]);
                        Breaking::create([
                            'work_id' => $work->id + 1,
                            'breaking_start' => Carbon::today()->startOfDay()->secondsSinceMidnight()
                        ]);
                    }

                    $allBreakingTime = $breakings->sum('breaking_time');
                    $workTime = $now->copy()->endOfDay()->secondsSinceMidnight() - $work->work_start - $allBreakingTime;
                    $work->update([
                        'allbreaking_time' => $allBreakingTime,
                        'work_time' => $workTime
                    ]);

                    if ($now->isSameMinute(Carbon::today()->startOfDay())) {
                        Work::create([
                            'user_id' => $user->id,
                            'work_date' => $now->format('Y_m_d'),
                            'work_start' => Carbon::today()->startOfDay()->secondsSinceMidnight()
                        ]);
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Midnight task failed:' . $e->getMessage());
        }
    }
}
