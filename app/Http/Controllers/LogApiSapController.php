<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\LogApiSap;

class LogApiSapController extends Controller
{
    public function index(Request $request)
    {
        $date_start = $request->date_start ? $request->date_start : "";
        $date_end = $request->date_end ? $request->date_end : "";

        $log = LogApiSap::whereBetween('created_at', [$date_start . " 00:00:00", $date_end . " 23:59:59"])->orderBy('id', 'DESC')->select('*');
        if ($request->ajax()) {
            return DataTables::of($log)
                ->editColumn('created_at', function ($log) {
                    return !empty($log->created_at) ? date("Y-m-d H:i:s", strtotime($log->created_at)) : null;
                })
                ->rawColumns(['created_at'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('log_sap.index', compact('date_start', 'date_end'));
    }
}
