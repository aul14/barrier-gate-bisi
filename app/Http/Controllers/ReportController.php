<?php

namespace App\Http\Controllers;

use App\Models\LogBarierGate;
use App\Models\RealBarier;
use App\Models\TrackStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

class ReportController extends Controller
{

    public function ajax_report(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;
        $report = [];

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        if (!empty($date_start) && !empty($date_end)) {
            $rp1 = RealBarier::generateReport($date_start, $date_end);
            $rp2 = RealBarier::generateVehicleReport($date_start, $date_end);
            $rp3 = RealBarier::generateScenarioReport($date_start, $date_end);

            $report = [$rp1, $rp2, $rp3];
        }

        return response()->json($report);
    }

    public function ajax_detail_barrier(Request $request)
    {
        $type_scenario = $request->type_scenario;
        $arrival_date = $request->arrival_date;
        $data = [];

        if ($request->ajax() && !empty($type_scenario) && !empty($arrival_date)) {
            $data = RealBarier::where('type_scenario', 'like', "%$type_scenario%")->where('arrival_date', $arrival_date)->get();
        }

        return response()->json($data);
    }

    public function ajax_detail_tracking(Request $request)
    {
        $plant = $request->plant;
        $sequence = $request->sequence;
        $arrival_date = $request->arrival_date;
        $data = [];

        if ($request->ajax() && !empty($sequence) && !empty($arrival_date) && !empty($plant)) {
            $data = TrackStatus::where('arrival_date', $arrival_date)->where('plant', $plant)->where('sequence', $sequence)->get();
        }

        return response()->json($data);
    }

    public function index(Request $request)
    {
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");

        if (!empty($date_start)  && !empty($date_end)) {
            $report = RealBarier::select(
                DB::raw('jenis_kendaraan as category'),
                DB::raw('count(*) as count'),
                DB::raw('null as count_inbounds'),
                DB::raw('null as count_outbounds'),
                DB::raw('null as count_others'),
                DB::raw('null as count_gate_1_1'),
                DB::raw('null as count_gate_1_2'),
                DB::raw('null as count_gate_2_1'),
                DB::raw('null as count_gate_2_2'),
                DB::raw('null as count_gate_3_1'),
                DB::raw('null as count_gate_3_2'),
                DB::raw('null as count_gate_4_1'),
                DB::raw('null as count_gate_4_2')
            )
                ->whereNotNull('jenis_kendaraan')
                ->where('jenis_kendaraan', '!=', '')
                ->groupBy('jenis_kendaraan')
                ->union(
                    RealBarier::select(
                        'arrival_date',
                        DB::raw('count(CASE WHEN type_scenario LIKE "%inbound%" THEN 1 END) as count_inbounds'),
                        DB::raw('count(CASE WHEN type_scenario LIKE "%outbound%" THEN 1 END) as count_outbounds'),
                        DB::raw('count(CASE WHEN type_scenario LIKE "%others%" THEN 1 END) as count_others'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 1, open gate BG1%" THEN 1 END) as count_gate_1_1'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 1, open gate BG2%" THEN 1 END) as count_gate_1_2'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 2, open gate BG1%" THEN 1 END) as count_gate_2_1'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 2, open gate BG2%" THEN 1 END) as count_gate_2_2'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 3, open gate BG1%" THEN 1 END) as count_gate_3_1'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 3, open gate BG2%" THEN 1 END) as count_gate_3_2'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 4, open gate BG1%" THEN 1 END) as count_gate_4_1'),
                        DB::raw('count(CASE WHEN status LIKE "%WB 4, open gate BG2%" THEN 1 END) as count_gate_4_2'),
                        DB::raw('null as category') // Adding null for the missing category column
                    )
                        ->whereBetween('arrival_date', ['2024-01-21', '2024-02-02'])
                        ->groupBy('arrival_date')
                )
                ->get();
        } else {
            $report = [];
        }

        if ($request->has('download')) {
            $pdf = FacadePdf::loadView('report.pdf', [
                'report' => $report
            ]);
            return $pdf->setPaper('a4', 'potrait')->download('report-pdf.pdf');
        }

        return view('report.index', compact('date_start', 'date_end', 'report'));
    }
}
