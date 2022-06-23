<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class PayRollController extends Controller
{
    public function payroll()
    {
        if (!auth()->user()->can('view_payroll')) {
            abort(403, 'Unauthorized Action');
        }

        return view('payroll');
    }

    public function payrollTable(Request $request)
    {
        if (!auth()->user()->can('view_payroll')) {
            abort(403, 'Unauthorized Action');
        }

        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year . '-' . $month . '-01'; // 2022-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); // 2022-02-28

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('name', 'like', '%' . $request->employee_name . '%')->get();
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
