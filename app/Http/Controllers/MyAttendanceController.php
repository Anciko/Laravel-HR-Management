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

class MyAttendanceController extends Controller
{
    public function ssd(Request $request)
    {
        $user = auth()->user();
        $attendances = CheckInCheckOut::with('employee')->where('user_id', $user->id);

        if($request->month) {
            $attendances = $attendances->whereMonth('date', $request->month);
        }

        if($request->year) {
            $attendances = $attendances->whereYear('date', $request->year);
        }

        return DataTables::of($attendances)
            ->addColumn('plus-icon', function ($each) {
                return null;
            })
            ->editColumn('user_id', function ($each) {
                return $each->employee->employee_id;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '';
                $delete_icon = '';
                if (auth()->user()->can('edit_attendance')) {
                    $edit_icon = '<a href=" ' . route('attendance.edit', $each->id) . ' " class="text-warning"   title="edit">
                    <i class="bx bxs-edit bx-sm"></i>
                    </a>';
                }
                if (auth()->user()->can('delete_attendance')) {
                    $delete_icon = '<a href="' . route('attendance.destroy', $each->id) . '" class="text-danger delete-btn" title="delete" data-id="' . $each->id . '">
                <i class="bx bxs-trash bx-sm"></i>
                </a>';
                }

                return '<div class="d-flex justify-content-center align-items-center align-middle">' . $edit_icon . $delete_icon . '</div>';
            })
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format("Y-m-d H:i:s");
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function myAttendanceOverviewTable(Request $request) {
        $month = $request->month;
        $year = $request->year;
        $startOfMonth = $year . '-' . $month . '-01'; // 2022-02-01
        $endOfMonth = Carbon::parse($startOfMonth)->endOfMonth()->format('Y-m-d'); // 2022-02-28

        $periods = new CarbonPeriod($startOfMonth, $endOfMonth);
        $employees = User::orderBy('employee_id')->where('id', auth()->user()->id)->get();
        $attendances = CheckInCheckOut::whereMonth('date', $month)->whereYear('date', $year)->get();
        $company_setting = CompanySetting::findOrFail(1);

        return view('components.attendance-overview-table', compact('periods', 'employees', 'attendances', 'company_setting'))->render();
    }

}
