<?php

namespace App\Http\Controllers;

use App\Models\CheckInCheckOut;
use App\Models\User;
use Illuminate\Http\Request;

class CheckInCheckOutController extends Controller
{
    public function checkInCheckOut()
    {
        return view('checkin_checkout');
    }

    public function checkInCheckOutStore(Request $request)
    {
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
                'status' => 'success',
                'message' => 'User is already check in and check out for today',
            ];
        }

        if (is_null($checkin_checkout->check_in_time)) {
            $checkin_checkout->check_in_time = now();
            $message = 'Successfully check in at ' . now();
        } else {
            if (is_null($checkin_checkout->check_out_time)) {
                $checkin_checkout->check_out_time = now();
                $message = "Successfully check out at " . now();
            }
        }

       $checkin_checkout->update();

        return [
            'status' => 'success',
            'message' => $message,
        ];
    }
}
