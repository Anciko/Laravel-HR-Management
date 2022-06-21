<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\CompanySetting;
use App\Models\User;
use Illuminate\Http\Request;

class CheckInCheckOutController extends Controller
{
    public function checkInCheckOut()
    {
        $company = CompanySetting::findOrFail(1);
        return view('checkin_checkout', compact('company'));
    }

    public function checkInCheckOutStore(Request $request)
    {
        if(now()->format('D') == 'Sat' || now()->format('D') == 'Sun') {
            return [
                'status' => 'error',
                'message' => 'Today is Off day.'
            ];
        }
        $user = User::where('pin_code', $request->pin_code)->first();

        if (!$user) {
            return [
                'status' => 'error',
                'message' => 'Pin Code is Wrong.',
            ];
        }

        $checkin_checkout = CheckInCheckOut::firstOrCreate([
            "user_id" => $user->id,
            "date" => now()->format('Y-m-d')
        ]);

        if (!is_null($checkin_checkout->check_in_time) && !is_null($checkin_checkout->check_out_time)) {
            return [
                'status' => 'error',
                'message' => 'User is already checked in and checked out for today',
            ];
        }

        if (is_null($checkin_checkout->check_in_time)) {
            $checkin_checkout->check_in_time = now();
            $message = 'Successfully checked in at ' . now();
        } else {
            if (is_null($checkin_checkout->check_out_time)) {
                $checkin_checkout->check_out_time = now();
                $message = "Successfully checked out at " . now();
            }
        }

       $checkin_checkout->update();

        return [
            'status' => 'success',
            'message' => $message,
        ];
    }
}
