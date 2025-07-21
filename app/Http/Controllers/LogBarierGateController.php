<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\LogBarierGate;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Yajra\DataTables\DataTables;

class LogBarierGateController extends Controller
{
    public function index(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        $log = LogBarierGate::whereBetween('date_at', [$date_start, $date_end])->orderBy('id', 'DESC')->select('*');
        if ($request->ajax()) {
            return DataTables::of($log)
                ->addColumn('scale_1', function ($log) {
                    $scale_1 = null;
                    if ($log->scaling_date_1 || $log->scaling_time_1 || $log->qty_scaling_1) {
                        $scale_1 .= "
                    <span class='badge bg-dark'>
                    $log->scaling_date_1</span> <br>
                    <span class='badge bg-dark'>
                    $log->scaling_time_1</span> <br>
                    <span class='badge bg-dark'>
                    $log->qty_scaling_1 KG</span>
                    ";
                    }

                    return $scale_1;
                })
                ->addColumn('scale_2', function ($log) {
                    $scale_2 = null;
                    if ($log->scaling_date_2 || $log->scaling_time_2 || $log->qty_scaling_2) {
                        $scale_2 .= "
                    <span class='badge bg-dark'>
                    $log->scaling_date_2</span> <br>
                    <span class='badge bg-dark'>
                    $log->scaling_time_2</span> <br>
                    <span class='badge bg-dark'>
                    $log->qty_scaling_2 KG</span>
                    ";
                    }

                    return $scale_2;
                })
                ->addColumn('scale_3', function ($log) {
                    $scale_3 = null;
                    if ($log->scaling_date_3 || $log->scaling_time_3 || $log->qty_scaling_3) {
                        $scale_3 .= "
                    <span class='badge bg-dark'>
                    $log->scaling_date_3</span> <br>
                    <span class='badge bg-dark'>
                    $log->scaling_time_3</span> <br>
                    <span class='badge bg-dark'>
                    $log->qty_scaling_3 KG</span>
                    ";
                    }

                    return $scale_3;
                })
                ->addColumn('scale_4', function ($log) {
                    $scale_4 = null;
                    if ($log->scaling_date_4 || $log->scaling_time_4 || $log->qty_scaling_4) {
                        $scale_4 .= "
                    <span class='badge bg-dark'>
                    $log->scaling_date_4</span> <br>
                    <span class='badge bg-dark'>
                    $log->scaling_time_4</span> <br>
                    <span class='badge bg-dark'>
                    $log->qty_scaling_4 KG</span>
                    ";
                    }

                    return $scale_4;
                })
                ->editColumn('updated_at', function ($log) {
                    return !empty($log->updated_at) ? date("d-m-Y H:i", strtotime($log->updated_at)) : null;
                })

                ->rawColumns(['scale_1', 'scale_2', 'scale_3', 'scale_4', 'updated_at'])
                ->addIndexColumn()
                ->make(true);
        }

        if ($request->has('download')) {
            $pdf = FacadePdf::loadView('log.log_pdf', [
                'log' => $log
            ]);
            return $pdf->setPaper('a4', 'landscape')->download('log-list.pdf');
        }
        return view('log.index', compact('date_start', 'date_end'));
    }
}
