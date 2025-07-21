<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class RealBarier extends Model
{
    use Compoships;

    public function track()
    {
        return $this->hasMany(TrackStatus::class, ['plant', 'sequence', 'arrival_date'], ['plant', 'sequence', 'arrival_date']);
    }

    public static function generateReport($date_start, $date_end)
    {
        return self::select('arrival_date')
            ->selectRaw("COUNT(case when type_scenario like '%inbound%' then 1 end) as count_inbounds")
            ->selectRaw("COUNT(case when type_scenario like '%outbound%' then 1 end) as count_outbounds")
            ->selectRaw("COUNT(case when type_scenario like '%others%' then 1 end) as count_others")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 1, open gate BG1 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_1_1_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 1, open gate BG2 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_1_2_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 1, open gate BG1 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_1_1_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 1, open gate BG2 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_1_2_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 1, open gate BG1 & BG2%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_1_12")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 2, open gate BG1 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_2_1_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 2, open gate BG2 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_2_2_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 2, open gate BG1 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_2_1_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 2, open gate BG2 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_2_2_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 2, open gate BG1 & BG2%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_2_12")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 3, open gate BG1 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_3_1_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 3, open gate BG2 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_3_2_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 3, open gate BG1 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_3_1_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 3, open gate BG2 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_3_2_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 3, open gate BG1 & BG2%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_3_12")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 4, open gate BG1 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_4_1_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 4, open gate BG2 - by SAP%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_4_2_sap")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 4, open gate BG1 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_4_1_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 4, open gate BG2 - by Dashboard Web%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_4_2_web")
            ->selectRaw("(SELECT COUNT(case when status like '%WB 4, open gate BG1 & BG2%' then 1 end) FROM `log_barier_gates` where real_bariers.arrival_date = log_barier_gates.arrival_date) as count_gate_4_12")
            ->groupBy('arrival_date')
            ->whereBetween('arrival_date', ["{$date_start}", "{$date_end}"])
            ->get();
    }

    public static function generateVehicleReport($date_start, $date_end)
    {
        return self::select('jenis_kendaraan as name', DB::raw('COUNT(jenis_kendaraan) as value'))
            ->whereBetween('arrival_date', ["{$date_start}", "{$date_end}"])
            ->groupBy('jenis_kendaraan')
            ->get();
    }

    public static function generateScenarioReport($date_start, $date_end)
    {
        return self::select('type_scenario as name', DB::raw('COUNT(type_scenario) as value'))
            ->whereBetween('arrival_date', ["{$date_start}", "{$date_end}"])
            ->groupBy('type_scenario')
            ->get();
    }
}