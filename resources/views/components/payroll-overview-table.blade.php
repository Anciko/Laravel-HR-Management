<div class="table-responsive mt-3">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="align-middle">Employee</th>
                <th class="text-center align-middle">Role</th>
                <th class="text-center align-middle">Days of Month</th>
                <th class="text-center align-middle">Working Days</th>
                <th class="text-center align-middle">Off Days</th>
                <th class="text-center align-middle">Attendance Days</th>
                <th class="text-center align-middle">Absence</th>
                <th class="text-center align-middle">Per Day (MMK)</th>
                <th class="text-center align-middle">Total (MMK)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                @php
                    $attendanceDays = 0;
                    $salary = collect($employee->salaries)->where('month', $month)->where('year', $year)->first();
                    $totalAmount = $salary->amount ?? 0;
                @endphp
                @foreach ($periods as $period)
                    @if ($period->isWeekday())
                        @php
                            $office_start_time = $period->format('Y-m-d') . ' ' . $company_setting->office_start_time;
                            $office_end_time = $period->format('Y-m-d') . ' ' . $company_setting->office_end_time;
                            $break_start_time = $period->format('Y-m-d') . ' ' . $company_setting->break_start_time;
                            $break_end_time = $period->format('Y-m-d') . ' ' . $company_setting->break_end_time;

                            $attendance = collect($attendances)
                                ->where('user_id', $employee->id)
                                ->where('date', $period->format('Y-m-d'))
                                ->first();

                            if ($attendance) {
                                // For Morning Section
                                if ($attendance->check_in_time <= $office_start_time) {
                                    $attendanceDays += 0.5;
                                } elseif ($attendance->check_in_time > $office_start_time && $attendance->check_in_time < $break_start_time) {
                                    $attendanceDays += 0.5;
                                } else {
                                    $attendanceDays += 0;
                                }
                                // For Afternoon Section
                                if ($attendance->check_out_time <= $break_end_time) {
                                    $attendanceDays += 0;
                                } elseif ($attendance->check_out_time < $office_end_time && $attendance->check_out_time > $break_end_time) {
                                    $attendanceDays += 0.5;
                                } else {
                                    $attendanceDays += 0.5;
                                }
                            }
                        @endphp
                    @endif
                @endforeach
                @php
                    $absentDays = $workingDays - $attendanceDays;
                    $salary_perday = $totalAmount / $attendanceDays;
                @endphp
                <tr class="text-center">
                    <td class="align-middle">{{ $employee->employee_id }}</td>
                    <td class="align-middle">{{ implode(', ', $employee->roles->pluck('name')->toArray()) }}</td>
                    <td class="align-middle">{{ $daysInMonth }}</td>
                    <td class="align-middle">{{ $workingDays }}</td>
                    <td class="align-middle"> {{ $offDays }} </td>
                    <td class="align-middle">{{ $attendanceDays }}</td>
                    <td class="align-middle"> {{ $absentDays }} </td>
                    <td class="align-middle"> {{ number_format( $salary_perday) }} </td>
                    <td class="align-middle"> {{ number_format($totalAmount) }} </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
