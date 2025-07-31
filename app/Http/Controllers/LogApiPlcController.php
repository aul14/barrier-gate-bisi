<?php

namespace App\Http\Controllers;

use App\Models\LogPlc;
use Illuminate\Http\Request;

class LogApiPlcController extends Controller
{
    public function store_log_plc(Request $request)
    {
        try {
            $log_plc = new LogPlc();
            $log_plc->parameter_plc = $request->url();
            $log_plc->body_plc = json_encode($request->all());
            $log_plc->save();

            return response()->json([
                'status' => 'success',
                'message'   => "Log PLC Created successfully.",
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        }
    }
}
