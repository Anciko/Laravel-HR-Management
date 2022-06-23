<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use App\Models\CheckInCheckOut;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Http\Controllers\Controller;

class MyPayRollController extends Controller
{
    public function myPayRollTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year . '-' . $month . '-01'; // 2022-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); // 2022-02-28

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id)->get();
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        $company_setting = CompanySetting::findOrFail(1);
        $daysInMonth = Carbon::parse($startOfMonth)->daysInMonth;
        $workingDays = Carbon::parse($startOfMonth)->subDays(1)->diffInDaysFiltered(function (Carbon $date) {
            return $date->isWeekday();
        }, Carbon::parse($endOfMonth));
        $offDays = $daysInMonth - $workingDays;

        return view('components.payroll-overview-table', compact('periods', 'employees', 'attendances', 'company_setting', 'daysInMonth', 'workingDays', 'offDays', 'month', 'year'))->render();
    }
}
