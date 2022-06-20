<?php

namespace Database\Seeders;

use App\Models\CheckInCheckOut;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    public function run()
    {
        $employees = User::all();
        foreach ($employees as $employee) {
            $periods = new CarbonPeriod('2021-01-01', '2022-06-30');
            foreach ($periods as $period) {
                $attendance = new CheckInCheckOut();
                $attendance->user_id = $employee->id;
                $attendance->date = $period->format('Y-m-d');
                $attendance->check_in_time = Carbon::parse($period->format('Y-m-d') . ' ' . '09:00:00')->subMinutes(rand(0, 55));
                $attendance->check_out_time = Carbon::parse($period->format('Y-m-d') . ' ' . '17:00:00')->addMinutes(rand(0, 55));
                $attendance->save();
            }
        }
    }
}
