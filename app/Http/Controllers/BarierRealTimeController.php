<?php

namespace App\Http\Controllers;

use App\Models\RealBarier;
use App\Models\TrackStatus;
use Illuminate\Http\Request;
use App\Models\LogBarierGate;
use Illuminate\Http\Response;
use App\Helpers\CodeNumbering;
use App\Events\BarierGateEvent;
use App\Models\LogApiSap;
use App\Models\TokenBarrierGate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BarierRealTimeController extends Controller
{
    public function destroy(Request $request)
    {
        $plant = $request->plant;
        $sequence = $request->sequence;
        $arrival_date = $request->arrival_date;
        $body_sap = json_encode($request->all());
        $api_url = env('API_URL');

        $log_sap = new LogApiSap();
        $log_sap->url = $request->url();
        $log_sap->json_sap = $body_sap;
        $log_sap->save();

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'plant'     => 'required',
                'sequence'       => 'required',
                'arrival_date'     => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message'   => $validator->messages(),
                ], Response::HTTP_BAD_REQUEST);
            }

            $data = RealBarier::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->first();
            if (empty($data)) {
                return response()->json([
                    'status' => 'error',
                    'message'   => 'Data not found!',
                ], Response::HTTP_BAD_REQUEST);
            } else {
                $data->delete();

                TrackStatus::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->delete();

                $log = new LogBarierGate();
                $log->code_bg = 0;
                $log->plant = $plant;
                $log->sequence = $sequence;
                $log->arrival_date = $arrival_date;
                $log->body_sap = $body_sap;
                $log->status = 'deleted';
                $log->next_status = 'deleted';
                $log->date_at = date('Y-m-d');
                $log->save();

                DB::commit();

                try {
                    return response()->json([
                        'status' => 'success',
                        'message'   => 'Data has been successfully deleted!',
                    ], 200);
                } finally {
                    Http::post("{$api_url}/real-time", [
                        'status' => $log->next_status,
                        'from'    => 'SAP',
                        'action' => null,
                        'antrian' => false,
                        'data_antrian' => []
                    ]);
                }
            }
        } catch (QueryException $th) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        }
    }

    public function registrasi(Request $request)
    {
        $plant = $request->plant;
        $sequence = $request->sequence;
        $truck_no = $request->truck_no;
        $arrival_date = $request->arrival_date;
        $po = $request->po;
        $sppb_no = $request->sppb_no;
        $reservation_no = $request->reservation_no;
        $sales_order_no = $request->sales_order_no;
        $material = $request->material;
        $arrival_time = $request->arrival_time;
        $type_scenario = strtolower($request->type_scenario);
        $vendor_do = $request->vendor_do;
        $jenis_kendaraan = $request->jenis_kendaraan;
        $next_status = strtolower($request->next_status);
        $ship_to_party = $request->ship_to_party;
        $delivery_order_no = $request->delivery_order_no;
        $from_storage_location = $request->from_storage_location;
        $upto_storage_location = $request->upto_storage_location;
        $truck_type = $request->truck_type;
        $scaling_date_1 = $request->scaling_date_1;
        $scaling_time_1 = $request->scaling_time_1;
        $qty_scaling_1 = preg_replace("/[^0-9]/", "", $request->qty_scaling_1);
        $scaling_date_2 = $request->scaling_date_2;
        $scaling_time_2 = $request->scaling_time_2;
        $qty_scaling_2 = preg_replace("/[^0-9]/", "", $request->qty_scaling_2);
        $quotation_no = $request->quotation_no;
        $upto_plant = $request->upto_plant;
        $body_sap = json_encode($request->all());
        $api_url = env('API_URL');
        $status_timbang = $request->status_timbang;
        $direction = $request->direction;
        $scaling_date_3 = $request->scaling_date_3;
        $scaling_time_3 = $request->scaling_time_3;
        $qty_scaling_3 = preg_replace("/[^0-9]/", "", $request->qty_scaling_3);
        $scaling_date_4 = $request->scaling_date_4;
        $scaling_time_4 = $request->scaling_time_4;
        $qty_scaling_4 = preg_replace("/[^0-9]/", "", $request->qty_scaling_4);

        $log_sap = new LogApiSap();
        $log_sap->url = $request->url();
        $log_sap->json_sap = $body_sap;
        $log_sap->save();

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'plant'     => 'required',
                'sequence'       => 'required',
                'truck_no'     => 'required',
                'arrival_date'     => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message'   => $validator->messages(),
                ], Response::HTTP_BAD_REQUEST);
            }


            $rb = new RealBarier();
            $code_bg = CodeNumbering::custom_code($rb, 'code_bg');

            $rb->code_bg = $code_bg;
            $rb->plant = $plant;
            $rb->sequence = $sequence;
            $rb->truck_no = $truck_no;
            $rb->arrival_date = $arrival_date;
            $rb->po = $po;
            $rb->arrival_time = $arrival_time;
            $rb->type_scenario = $type_scenario;
            $rb->sppb_no = $sppb_no;
            $rb->material = $material;
            $rb->vendor_do = $vendor_do;
            $rb->jenis_kendaraan = $jenis_kendaraan;
            $rb->status = $type_scenario == 'scaling others' ? 'registration scale' : 'registration';
            $rb->next_status = $next_status;
            $rb->ship_to_party = $ship_to_party;
            $rb->scaling_date_1 = $scaling_date_1;
            $rb->scaling_time_1 = $scaling_time_1;
            $rb->qty_scaling_1 = $qty_scaling_1;
            $rb->scaling_date_2 = $scaling_date_2;
            $rb->scaling_time_2 = $scaling_time_2;
            $rb->qty_scaling_2 = $qty_scaling_2;
            $rb->delivery_order_no = $delivery_order_no;
            $rb->from_storage_location = $from_storage_location;
            $rb->upto_storage_location = $upto_storage_location;
            $rb->truck_type = $truck_type;
            $rb->reservation_no = $reservation_no;
            $rb->sales_order_no = $sales_order_no;
            $rb->quotation_no = $quotation_no;
            $rb->upto_plant = $upto_plant;
            if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                $rb->status_timbang = $status_timbang;
            } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                $rb->status_timbang_2 = $status_timbang;
            } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                $rb->status_timbang_3 = $status_timbang;
            } else {
                $rb->status_timbang_4 = $status_timbang;
            }
            $rb->direction = $direction;
            $rb->scaling_date_3 = $scaling_date_3;
            $rb->scaling_time_3 = $scaling_time_3;
            $rb->qty_scaling_3 = $qty_scaling_3;
            $rb->scaling_date_4 = $scaling_date_4;
            $rb->scaling_time_4 = $scaling_time_4;
            $rb->qty_scaling_4 = $qty_scaling_4;
            $rb->save();

            $log = new LogBarierGate();
            $log->code_bg = $code_bg;
            $log->plant = $plant;
            $log->sequence = $sequence;
            $log->truck_no = $truck_no;
            $log->arrival_date = $arrival_date;
            $log->po = $po;
            $log->sppb_no = $sppb_no;
            $log->material = $material;
            $log->ship_to_party = $ship_to_party;
            $log->arrival_time = $arrival_time;
            $log->type_scenario = $type_scenario;
            $log->vendor_do = $vendor_do;
            $log->jenis_kendaraan = $jenis_kendaraan;
            $log->status = $type_scenario == 'scaling others' ? 'registration scale' : 'registration';
            $log->next_status = $next_status;
            $log->scaling_date_1 = $scaling_date_1;
            $log->scaling_time_1 = $scaling_time_1;
            $log->qty_scaling_1 = $qty_scaling_1;
            $log->scaling_date_2 = $scaling_date_2;
            $log->scaling_time_2 = $scaling_time_2;
            $log->qty_scaling_2 = $qty_scaling_2;
            $log->delivery_order_no = $delivery_order_no;
            $log->from_storage_location = $from_storage_location;
            $log->upto_storage_location = $upto_storage_location;
            $log->reservation_no = $reservation_no;
            $log->sales_order_no = $sales_order_no;
            $log->quotation_no = $quotation_no;
            $log->upto_plant = $upto_plant;
            $log->truck_type = $truck_type;
            $log->body_sap = $body_sap;
            if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                $log->status_timbang = $status_timbang;
            } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                $log->status_timbang_2 = $status_timbang;
            } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                $log->status_timbang_3 = $status_timbang;
            } else {
                $log->status_timbang_4 = $status_timbang;
            }
            $log->direction = $direction;
            $log->scaling_date_3 = $scaling_date_3;
            $log->scaling_time_3 = $scaling_time_3;
            $log->qty_scaling_3 = $qty_scaling_3;
            $log->scaling_date_4 = $scaling_date_4;
            $log->scaling_time_4 = $scaling_time_4;
            $log->qty_scaling_4 = $qty_scaling_4;
            $log->date_at = date('Y-m-d');
            $log->save();

            $ts = new TrackStatus();
            $ts->plant = $plant;
            $ts->sequence = $sequence;
            $ts->arrival_date = $arrival_date;
            $ts->status = $type_scenario == 'scaling others' ? 'registration scale' : 'registration';
            $ts->save();

            $ts = new TrackStatus();
            $ts->plant = $plant;
            $ts->sequence = $sequence;
            $ts->arrival_date = $arrival_date;
            $ts->status = $next_status;
            $ts->save();

            DB::commit();

            try {
                return response()->json([
                    'status' => 'success',
                    'message'   => 'Data has been successfully saved!',
                ], 201);
            } finally {
                Http::post("{$api_url}/real-time", [
                    'status'  => $next_status,
                    'from'    => 'SAP',
                    'action'  => null,
                    'antrian' => false,
                    'data_antrian' => []
                ]);

                $responseDoCollect = Http::withHeaders([
                    'Token' => env('TOKEN_DO_COLLECT')
                ])->post(env('ENDPOINT_DO_COLLECT'), $request->all());

                Log::info('Response from DO Collect API:', ['response' => $responseDoCollect->json()]);

                if ($responseDoCollect->successful()) {
                    Log::info('Data successfully inserted.');
                } else {
                    Log::error('Failed to insert data.', ['status' => $responseDoCollect->status(), 'response' => $responseDoCollect->body()]);
                }
            }
        } catch (QueryException $th) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        }
    }

    public function update_token(Request $request)
    {
        $token = $request->token;
        $log_sap = new LogApiSap();
        $log_sap->url = $request->url();
        $log_sap->json_sap = json_encode($request->all());
        $log_sap->save();
        try {
            $cek_token = TokenBarrierGate::first();
            if (!$cek_token) {
                // cek if toke is null
                $tkn = new TokenBarrierGate();
                $tkn->token = Hash::make($token);
                $tkn->save();

                return response()->json([
                    'status' => 'success',
                    'message'   => 'Token saved succesfully!',
                ], 201);
            } else {
                $cek_token->token = Hash::make($token);
                $cek_token->update();

                return response()->json([
                    'status' => 'success',
                    'message'   => 'Token updated succesfully!',
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        }
    }

    public function status(Request $request)
    {
        $wb = $request->wb;
        $api_url = env('API_URL');

        $log_sap = new LogApiSap();
        $log_sap->url = $request->url();
        $log_sap->json_sap = json_encode($request->all());
        $log_sap->save();

        if ($wb) {
            $response = Http::get("{$api_url}/status?WB={$wb}");

            $data = $response->json();

            return response()->json([
                'status' => 'success',
                'message'   => "Status is found!",
                'data'  => $data
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message'   => "Parameter WB is null, status is not found!",
            ], 422);
        }
    }

    public function timbangan(Request $request)
    {
        $wb_condition = $request->wb_condition;
        $open_gate = $request->open_gate;
        $close_gate = $request->close_gate;
        $wb = $request->wb;
        $token = $request->token;

        $plant = $request->plant;
        $sequence = $request->sequence;
        $truck_no = $request->truck_no;
        $arrival_date = $request->arrival_date;
        $po = $request->po;
        $sppb_no = $request->sppb_no;
        $material = $request->material;
        $arrival_time = $request->arrival_time;
        $type_scenario = strtolower($request->type_scenario);
        $vendor_do = $request->vendor_do;
        $jenis_kendaraan = $request->jenis_kendaraan;
        $next_status = strtolower($request->next_status);
        $scaling_date_1 = $request->scaling_date_1;
        $scaling_time_1 = $request->scaling_time_1;
        $qty_scaling_1 = preg_replace("/[^0-9]/", "", $request->qty_scaling_1);
        $scaling_date_2 = $request->scaling_date_2;
        $scaling_time_2 = $request->scaling_time_2;
        $qty_scaling_2 = preg_replace("/[^0-9]/", "", $request->qty_scaling_2);
        $ship_to_party = $request->ship_to_party;
        $delivery_order_no = $request->delivery_order_no;
        $from_storage_location = $request->from_storage_location;
        $upto_storage_location = $request->upto_storage_location;
        $truck_type = $request->truck_type;
        $reservation_no = $request->reservation_no;
        $sales_order_no = $request->sales_order_no;
        $quotation_no = $request->quotation_no;
        $upto_plant = $request->upto_plant;
        $body_sap = json_encode($request->all());
        $status_timbang = $request->status_timbang;
        $direction = $request->direction;
        $scaling_date_3 = $request->scaling_date_3;
        $scaling_time_3 = $request->scaling_time_3;
        $qty_scaling_3 = preg_replace("/[^0-9]/", "", $request->qty_scaling_3);
        $scaling_date_4 = $request->scaling_date_4;
        $scaling_time_4 = $request->scaling_time_4;
        $qty_scaling_4 = preg_replace("/[^0-9]/", "", $request->qty_scaling_4);

        $api_url = env('API_URL');

        $log_sap = new LogApiSap();
        $log_sap->url = $request->url();
        $log_sap->json_sap = $body_sap;
        $log_sap->save();

        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'plant'     => 'required',
                'sequence'       => 'required',
                'arrival_date'     => 'required|date',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message'   => $validator->messages(),
                ], Response::HTTP_BAD_REQUEST);
            }

            $cek_rb = RealBarier::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->first();

            if (!empty($wb) || !empty($wb_condition) || !empty($open_gate) || !empty($close_gate)) {
                if ($cek_rb) {
                    if (!empty($next_status)) {
                        $cek_rb->plant = $plant;
                        $cek_rb->sequence = $sequence;
                        $cek_rb->arrival_date = $arrival_date;
                        $cek_rb->po = !empty($po) ? $po : $cek_rb->po;
                        $cek_rb->truck_no = !empty($truck_no) ? $truck_no : $cek_rb->truck_no;
                        $cek_rb->sppb_no = !empty($sppb_no) ? $sppb_no : $cek_rb->sppb_no;
                        $cek_rb->material = !empty($material) ? $material : $cek_rb->material;
                        $cek_rb->arrival_time = !empty($arrival_time) ? $arrival_time : $cek_rb->arrival_time;
                        $cek_rb->type_scenario = !empty($type_scenario) ? $type_scenario : $cek_rb->type_scenario;
                        $cek_rb->vendor_do = !empty($vendor_do) ? $vendor_do : $cek_rb->vendor_do;
                        $cek_rb->jenis_kendaraan = !empty($jenis_kendaraan) ? $jenis_kendaraan : $cek_rb->jenis_kendaraan;
                        $cek_rb->status = $cek_rb->next_status;
                        $cek_rb->next_status = $next_status;
                        $cek_rb->scaling_date_1 = !empty($scaling_date_1) ? $scaling_date_1 : $cek_rb->scaling_date_1;
                        $cek_rb->scaling_time_1 = !empty($scaling_time_1) ? $scaling_time_1 : $cek_rb->scaling_time_1;
                        $cek_rb->qty_scaling_1 = !empty($qty_scaling_1) ? $qty_scaling_1 : $cek_rb->qty_scaling_1;
                        $cek_rb->scaling_date_2 = !empty($scaling_date_2) ? $scaling_date_2 : $cek_rb->scaling_date_2;
                        $cek_rb->scaling_time_2 = !empty($scaling_time_2) ? $scaling_time_2 : $cek_rb->scaling_time_2;
                        $cek_rb->qty_scaling_2 = !empty($qty_scaling_2) ? $qty_scaling_2 : $cek_rb->qty_scaling_2;
                        $cek_rb->ship_to_party = !empty($ship_to_party) ? $ship_to_party : $cek_rb->ship_to_party;
                        $cek_rb->delivery_order_no = !empty($delivery_order_no) ? $delivery_order_no : $cek_rb->delivery_order_no;
                        $cek_rb->from_storage_location = !empty($from_storage_location) ? $from_storage_location : $cek_rb->from_storage_location;
                        $cek_rb->upto_storage_location = !empty($upto_storage_location) ? $upto_storage_location : $cek_rb->upto_storage_location;
                        $cek_rb->truck_type = !empty($truck_type) ? $truck_type : $cek_rb->truck_type;
                        $cek_rb->reservation_no = !empty($reservation_no) ? $reservation_no : $cek_rb->reservation_no;
                        $cek_rb->sales_order_no = !empty($sales_order_no) ? $sales_order_no : $cek_rb->sales_order_no;
                        $cek_rb->quotation_no = !empty($quotation_no) ? $quotation_no : $cek_rb->quotation_no;
                        $cek_rb->upto_plant = !empty($upto_plant) ? $upto_plant : $cek_rb->upto_plant;

                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $cek_rb->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $cek_rb->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $cek_rb->status_timbang_3 = $status_timbang;
                        } else {
                            $cek_rb->status_timbang_4 = $status_timbang;
                        }

                        $cek_rb->direction = !empty($direction) ? $direction : $cek_rb->direction;
                        $cek_rb->scaling_date_3 = !empty($scaling_date_3) ? $scaling_date_3 : $cek_rb->scaling_date_3;
                        $cek_rb->scaling_time_3 = !empty($scaling_time_3) ? $scaling_time_3 : $cek_rb->scaling_time_3;
                        $cek_rb->qty_scaling_3 = !empty($qty_scaling_3) ? $qty_scaling_3 : $cek_rb->qty_scaling_3;
                        $cek_rb->scaling_date_4 = !empty($scaling_date_4) ? $scaling_date_4 : $cek_rb->scaling_date_4;
                        $cek_rb->scaling_time_4 = !empty($scaling_time_4) ? $scaling_time_4 : $cek_rb->scaling_time_4;
                        $cek_rb->qty_scaling_4 = !empty($qty_scaling_4) ? $qty_scaling_4 : $cek_rb->qty_scaling_4;
                        $cek_rb->updated_at = now();
                        $cek_rb->update();

                        $ts = new TrackStatus();
                        $ts_arr = [
                            [
                                'plant' => $plant,
                                'sequence' => $sequence,
                                'arrival_date' => $arrival_date,
                                'status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2" : "WB {$wb}, open gate {$open_gate}",
                                'created_at' => now(),
                                'updated_at' => now()
                            ],
                            [
                                'plant' => $plant,
                                'sequence' => $sequence,
                                'arrival_date' => $arrival_date,
                                'status' => $next_status,
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        ];
                        $ts->insert($ts_arr);

                        $log = new LogBarierGate();
                        $log_arr = [
                            [
                                'plant' => $plant,
                                'sequence' => $sequence,
                                'truck_no' => $truck_no,
                                'arrival_date' => $arrival_date,
                                'arrival_time' => $arrival_time,
                                'type_scenario' => $type_scenario,
                                'vendor_do' => $vendor_do,
                                'jenis_kendaraan' => $jenis_kendaraan,
                                'status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2 - by SAP" : "WB {$wb}, open gate {$open_gate} - by SAP",
                                'next_status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2 - by SAP" : "WB {$wb}, open gate {$open_gate} - by SAP",
                                'scaling_date_1' => $scaling_date_1,
                                'scaling_time_1' => $scaling_time_1,
                                'qty_scaling_1' => $qty_scaling_1,
                                'scaling_date_2' => $scaling_date_2,
                                'scaling_time_2' => $scaling_time_2,
                                'qty_scaling_2' => $qty_scaling_2,
                                'ship_to_party' => $ship_to_party,
                                'delivery_order_no' => $delivery_order_no,
                                'from_storage_location' => $from_storage_location,
                                'upto_storage_location' => $upto_storage_location,
                                'truck_type' => $truck_type,
                                'reservation_no' => $reservation_no,
                                'sales_order_no' => $sales_order_no,
                                'quotation_no' => $quotation_no,
                                'upto_plant' => $upto_plant,
                                'body_sap' => $body_sap,
                                'status_timbang' => (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) ? $status_timbang : null,
                                'status_timbang_2' => (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) ? $status_timbang : null,
                                'status_timbang_3' => (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) ? $status_timbang : null,
                                'status_timbang_4' => (!empty($scaling_date_4) && !empty($scaling_time_4) && !empty($qty_scaling_4)) ? $status_timbang : null,
                                'direction' => $direction,
                                'scaling_date_3' => $scaling_date_3,
                                'scaling_time_3' => $scaling_time_3,
                                'qty_scaling_3' => $qty_scaling_3,
                                'scaling_date_4' => $scaling_date_4,
                                'scaling_time_4' => $scaling_time_4,
                                'qty_scaling_4' => $qty_scaling_4,
                                'code_bg' => $cek_rb->code_bg,
                                'date_at' => date('Y-m-d'),
                                'created_at' => now(),
                                'updated_at' => now()
                            ],
                            [
                                'plant' => $plant,
                                'sequence' => $sequence,
                                'truck_no' => $truck_no,
                                'arrival_date' => $arrival_date,
                                'arrival_time' => $arrival_time,
                                'type_scenario' => $type_scenario,
                                'vendor_do' => $vendor_do,
                                'jenis_kendaraan' => $jenis_kendaraan,
                                'status' => $next_status,
                                'next_status' => $next_status,
                                'scaling_date_1' => $scaling_date_1,
                                'scaling_time_1' => $scaling_time_1,
                                'qty_scaling_1' => $qty_scaling_1,
                                'scaling_date_2' => $scaling_date_2,
                                'scaling_time_2' => $scaling_time_2,
                                'qty_scaling_2' => $qty_scaling_2,
                                'ship_to_party' => $ship_to_party,
                                'delivery_order_no' => $delivery_order_no,
                                'from_storage_location' => $from_storage_location,
                                'upto_storage_location' => $upto_storage_location,
                                'truck_type' => $truck_type,
                                'reservation_no' => $reservation_no,
                                'sales_order_no' => $sales_order_no,
                                'quotation_no' => $quotation_no,
                                'upto_plant' => $upto_plant,
                                'body_sap' => $body_sap,
                                'status_timbang' => (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) ? $status_timbang : null,
                                'status_timbang_2' => (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) ? $status_timbang : null,
                                'status_timbang_3' => (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) ? $status_timbang : null,
                                'status_timbang_4' => (!empty($scaling_date_4) && !empty($scaling_time_4) && !empty($qty_scaling_4)) ? $status_timbang : null,
                                'direction' => $direction,
                                'scaling_date_3' => $scaling_date_3,
                                'scaling_time_3' => $scaling_time_3,
                                'qty_scaling_3' => $qty_scaling_3,
                                'scaling_date_4' => $scaling_date_4,
                                'scaling_time_4' => $scaling_time_4,
                                'qty_scaling_4' => $qty_scaling_4,
                                'code_bg' => $cek_rb->code_bg,
                                'date_at' => date('Y-m-d'),
                                'created_at' => now(),
                                'updated_at' => now()
                            ]
                        ];
                        $log->insert($log_arr);

                        // CEK TOKEN
                        if ($token) {
                            $get_token = TokenBarrierGate::first();
                            if ($get_token) {
                                $cek_token = Hash::check($token, $get_token->token);
                                if ($cek_token) {
                                    Http::post("{$api_url}?WB={$wb}", [
                                        "open" => $open_gate,
                                        "close" => $close_gate,
                                        "gandeng" => ($wb_condition == "short") ? 1 : 0,
                                        "manuver" => ($wb_condition == "long") ? 1 : 0,
                                        "save" => $direction == 'manuver' && $wb_condition == "long" ? true : false,
                                        "manuver1862" => $direction == 'manuver1862' && $wb_condition == "short" ? true : false,
                                    ]);

                                    try {
                                        DB::commit();
                                        return response()->json([
                                            'status' => 'success',
                                            'message'   => "Data has been successfully updated, wb {$wb} barrier gate {$open_gate} is open!",
                                        ], 200);
                                    } finally {
                                        Http::post("{$api_url}/real-time", [
                                            'status'  => $next_status,
                                            'wb'  => $wb,
                                            'open_gate'  => $open_gate,
                                            'wb_condition'  => $wb_condition,
                                            'direction'  => $direction,
                                            'from'    => 'SAP',
                                            'truck_no' => !empty($truck_no) ? $truck_no : $cek_rb->truck_no,
                                            'antrian' => true,
                                            'data_antrian' => [$plant, $sequence, $arrival_date]
                                        ]);
                                    }
                                } else {
                                    DB::rollback();
                                    return response()->json([
                                        'status' => 'error',
                                        'message'   => "Token is invalid!",
                                    ], 422);
                                }
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => 'error',
                                    'message'   => "Token has not been registered, please register the token first",
                                ], 422);
                            }
                        } else {
                            DB::rollback();
                            return response()->json([
                                'status' => 'error',
                                'message'   => "Token cannot be empty!",
                            ], 422);
                        }
                    } else {
                        $cek_rb->plant = $plant;
                        $cek_rb->sequence = $sequence;
                        $cek_rb->arrival_date = $arrival_date;
                        $cek_rb->po = !empty($po) ? $po : $cek_rb->po;
                        $cek_rb->truck_no = !empty($truck_no) ? $truck_no : $cek_rb->truck_no;
                        $cek_rb->sppb_no = !empty($sppb_no) ? $sppb_no : $cek_rb->sppb_no;
                        $cek_rb->material = !empty($material) ? $material : $cek_rb->material;
                        $cek_rb->arrival_time = !empty($arrival_time) ? $arrival_time : $cek_rb->arrival_time;
                        $cek_rb->type_scenario = !empty($type_scenario) ? $type_scenario : $cek_rb->type_scenario;
                        $cek_rb->vendor_do = !empty($vendor_do) ? $vendor_do : $cek_rb->vendor_do;
                        $cek_rb->jenis_kendaraan = !empty($jenis_kendaraan) ? $jenis_kendaraan : $cek_rb->jenis_kendaraan;
                        $cek_rb->status = $cek_rb->status;
                        $cek_rb->next_status = $cek_rb->next_status;
                        $cek_rb->scaling_date_1 = !empty($scaling_date_1) ? $scaling_date_1 : $cek_rb->scaling_date_1;
                        $cek_rb->scaling_time_1 = !empty($scaling_time_1) ? $scaling_time_1 : $cek_rb->scaling_time_1;
                        $cek_rb->qty_scaling_1 = !empty($qty_scaling_1) ? $qty_scaling_1 : $cek_rb->qty_scaling_1;
                        $cek_rb->scaling_date_2 = !empty($scaling_date_2) ? $scaling_date_2 : $cek_rb->scaling_date_2;
                        $cek_rb->scaling_time_2 = !empty($scaling_time_2) ? $scaling_time_2 : $cek_rb->scaling_time_2;
                        $cek_rb->qty_scaling_2 = !empty($qty_scaling_2) ? $qty_scaling_2 : $cek_rb->qty_scaling_2;
                        $cek_rb->ship_to_party = !empty($ship_to_party) ? $ship_to_party : $cek_rb->ship_to_party;
                        $cek_rb->delivery_order_no = !empty($delivery_order_no) ? $delivery_order_no : $cek_rb->delivery_order_no;
                        $cek_rb->from_storage_location = !empty($from_storage_location) ? $from_storage_location : $cek_rb->from_storage_location;
                        $cek_rb->upto_storage_location = !empty($upto_storage_location) ? $upto_storage_location : $cek_rb->upto_storage_location;
                        $cek_rb->truck_type = !empty($truck_type) ? $truck_type : $cek_rb->truck_type;
                        $cek_rb->reservation_no = !empty($reservation_no) ? $reservation_no : $cek_rb->reservation_no;
                        $cek_rb->sales_order_no = !empty($sales_order_no) ? $sales_order_no : $cek_rb->sales_order_no;
                        $cek_rb->quotation_no = !empty($quotation_no) ? $quotation_no : $cek_rb->quotation_no;
                        $cek_rb->upto_plant = !empty($upto_plant) ? $upto_plant : $cek_rb->upto_plant;

                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $cek_rb->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $cek_rb->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $cek_rb->status_timbang_3 = $status_timbang;
                        } else {
                            $cek_rb->status_timbang_4 = $status_timbang;
                        }

                        $cek_rb->direction = !empty($direction) ? $direction : $cek_rb->direction;
                        $cek_rb->scaling_date_3 = !empty($scaling_date_3) ? $scaling_date_3 : $cek_rb->scaling_date_3;
                        $cek_rb->scaling_time_3 = !empty($scaling_time_3) ? $scaling_time_3 : $cek_rb->scaling_time_3;
                        $cek_rb->qty_scaling_3 = !empty($qty_scaling_3) ? $qty_scaling_3 : $cek_rb->qty_scaling_3;
                        $cek_rb->scaling_date_4 = !empty($scaling_date_4) ? $scaling_date_4 : $cek_rb->scaling_date_4;
                        $cek_rb->scaling_time_4 = !empty($scaling_time_4) ? $scaling_time_4 : $cek_rb->scaling_time_4;
                        $cek_rb->qty_scaling_4 = !empty($qty_scaling_4) ? $qty_scaling_4 : $cek_rb->qty_scaling_4;
                        $cek_rb->updated_at = now();
                        $cek_rb->update();

                        $ts_old = TrackStatus::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->orderBy('id', 'DESC')->first();
                        if (!empty($ts_old)) {
                            $status_ts_old = $ts_old->status;

                            $ts_limit_2 = TrackStatus::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->orderBy('id', 'DESC')->limit('2')->select('plant', 'sequence', 'arrival_date', 'status')->get();

                            $ts_data_old = [
                                [
                                    'plant' => $plant,
                                    'sequence' => $sequence,
                                    'arrival_date' => $arrival_date,
                                    'status' => $status_ts_old,
                                ],
                                [
                                    'plant' => $plant,
                                    'sequence' => $sequence,
                                    'arrival_date' => $arrival_date,
                                    'status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2" : "WB {$wb}, open gate {$open_gate}",
                                ],
                            ];


                            $ts_bool = $ts_limit_2->toArray() == $ts_data_old;
                            if (!$ts_bool) {
                                $ts_old->delete();
                                $ts_data = [
                                    [
                                        'plant' => $plant,
                                        'sequence' => $sequence,
                                        'arrival_date' => $arrival_date,
                                        'status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2" : "WB {$wb}, open gate {$open_gate}",
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ],
                                    [
                                        'plant' => $plant,
                                        'sequence' => $sequence,
                                        'arrival_date' => $arrival_date,
                                        'status' => $status_ts_old,
                                        'created_at' => now(),
                                        'updated_at' => now()
                                    ],
                                ];
                                TrackStatus::insert($ts_data);
                            } else {
                                // CEK KONDISI BOLEH MENAMPILKAN DATA OPEN GATE TRACK STATUS 2X, JIKA TYPE SCENARIONYA SCALLING OTHERS
                                $count_get = TrackStatus::where('plant', $plant)->where('sequence', $sequence)->where('arrival_date', $arrival_date)->where('status', (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2" : "WB {$wb}, open gate {$open_gate}")->limit('3')->orderBy('id', 'DESC')->get();
                                // if ($cek_rb->type_scenario == 'scaling others') {
                                if (count($count_get) == 1) {
                                    $ts_old->delete();
                                    $ts_data = [
                                        [
                                            'plant' => $plant,
                                            'sequence' => $sequence,
                                            'arrival_date' => $arrival_date,
                                            'status' => (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2" : "WB {$wb}, open gate {$open_gate}",
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ],
                                        [
                                            'plant' => $plant,
                                            'sequence' => $sequence,
                                            'arrival_date' => $arrival_date,
                                            'status' => $ts_old->status,
                                            'created_at' => now(),
                                            'updated_at' => now()
                                        ],
                                    ];
                                    TrackStatus::insert($ts_data);
                                }
                            }
                        }

                        $log = new LogBarierGate();
                        $log->plant = $plant;
                        $log->sequence = $sequence;
                        $log->truck_no = $truck_no;
                        $log->arrival_date = $arrival_date;
                        $log->arrival_time = $arrival_time;
                        $log->type_scenario = $type_scenario;
                        $log->vendor_do = $vendor_do;
                        $log->jenis_kendaraan = $jenis_kendaraan;
                        $log->status = (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2 - by SAP" : "WB {$wb}, open gate {$open_gate} - by SAP";
                        $log->next_status = (($wb_condition == 'long' && $direction == null) || ($wb_condition == 'short' && $direction == null)) ? "WB {$wb}, open gate BG1 & BG2 - by SAP" : "WB {$wb}, open gate {$open_gate} - by SAP";
                        $log->scaling_date_1 = $scaling_date_1;
                        $log->scaling_time_1 = $scaling_time_1;
                        $log->qty_scaling_1 = $qty_scaling_1;
                        $log->scaling_date_2 = $scaling_date_2;
                        $log->scaling_time_2 = $scaling_time_2;
                        $log->qty_scaling_2 = $qty_scaling_2;
                        $log->ship_to_party = $ship_to_party;
                        $log->delivery_order_no = $delivery_order_no;
                        $log->from_storage_location = $from_storage_location;
                        $log->upto_storage_location = $upto_storage_location;
                        $log->truck_type = $truck_type;
                        $log->reservation_no = $reservation_no;
                        $log->sales_order_no = $sales_order_no;
                        $log->quotation_no = $quotation_no;
                        $log->upto_plant = $upto_plant;
                        $log->body_sap = $body_sap;
                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $log->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $log->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $log->status_timbang_3 = $status_timbang;
                        } else {
                            $log->status_timbang_4 = $status_timbang;
                        }
                        $log->direction = $direction;
                        $log->scaling_date_3 = $scaling_date_3;
                        $log->scaling_time_3 = $scaling_time_3;
                        $log->qty_scaling_3 = $qty_scaling_3;
                        $log->scaling_date_4 = $scaling_date_4;
                        $log->scaling_time_4 = $scaling_time_4;
                        $log->qty_scaling_4 = $qty_scaling_4;
                        $log->code_bg = $cek_rb->code_bg;
                        $log->date_at = date('Y-m-d');
                        $log->save();

                        // CEK TOKEN
                        if ($token) {
                            $get_token = TokenBarrierGate::first();
                            if ($get_token) {
                                $cek_token = Hash::check($token, $get_token->token);
                                if ($cek_token) {
                                    Http::post("{$api_url}?WB={$wb}", [
                                        "open" => $open_gate,
                                        "close" => $close_gate,
                                        "gandeng" => ($wb_condition == "short") ? 1 : 0,
                                        "manuver" => ($wb_condition == "long") ? 1 : 0,
                                        "save" => $direction == 'manuver' && $wb_condition == "long" ? true : false,
                                        "manuver1862" => $direction == 'manuver1862' && $wb_condition == "short" ? true : false,
                                    ]);

                                    try {
                                        DB::commit();
                                        return response()->json([
                                            'status' => 'success',
                                            'message'   => "Data has been successfully updated, wb {$wb} barrier gate {$open_gate} is open!",
                                        ], 200);
                                    } finally {
                                        Http::post("{$api_url}/real-time", [
                                            'status'  => $next_status,
                                            'wb'  => $wb,
                                            'open_gate'  => $open_gate,
                                            'wb_condition'  => $wb_condition,
                                            'direction'  => $direction,
                                            'from'    => 'SAP',
                                            'truck_no' => !empty($truck_no) ? $truck_no : $cek_rb->truck_no,
                                            'antrian' => true,
                                            'data_antrian' => [$plant, $sequence, $arrival_date]
                                        ]);
                                    }
                                } else {
                                    DB::rollback();
                                    return response()->json([
                                        'status' => 'error',
                                        'message'   => "Token is invalid!",
                                    ], 422);
                                }
                            } else {
                                DB::rollback();
                                return response()->json([
                                    'status' => 'error',
                                    'message'   => "Token has not been registered, please register the token first",
                                ], 422);
                            }
                        } else {
                            DB::rollback();
                            return response()->json([
                                'status' => 'error',
                                'message'   => "Token cannot be empty!",
                            ], 422);
                        }
                    }
                } else {
                    DB::rollback();

                    return response()->json([
                        'status' => 'error',
                        'message'   => 'Plant or sequence or arrival date. is not found, please register first!',
                    ], 422);
                }
            } else {
                if ($cek_rb) {
                    if (!empty($next_status)) {
                        $cek_rb->plant = $plant;
                        $cek_rb->sequence = $sequence;
                        $cek_rb->arrival_date = $arrival_date;
                        $cek_rb->po = !empty($po) ? $po : $cek_rb->po;
                        $cek_rb->truck_no = !empty($truck_no) ? $truck_no : $cek_rb->truck_no;
                        $cek_rb->sppb_no = !empty($sppb_no) ? $sppb_no : $cek_rb->sppb_no;
                        $cek_rb->material = !empty($material) ? $material : $cek_rb->material;
                        $cek_rb->arrival_time = !empty($arrival_time) ? $arrival_time : $cek_rb->arrival_time;
                        $cek_rb->type_scenario = !empty($type_scenario) ? $type_scenario : $cek_rb->type_scenario;
                        $cek_rb->vendor_do = !empty($vendor_do) ? $vendor_do : $cek_rb->vendor_do;
                        $cek_rb->jenis_kendaraan = !empty($jenis_kendaraan) ? $jenis_kendaraan : $cek_rb->jenis_kendaraan;
                        $cek_rb->status = $cek_rb->next_status;
                        $cek_rb->next_status = $next_status;
                        $cek_rb->scaling_date_1 = !empty($scaling_date_1) ? $scaling_date_1 : $cek_rb->scaling_date_1;
                        $cek_rb->scaling_time_1 = !empty($scaling_time_1) ? $scaling_time_1 : $cek_rb->scaling_time_1;
                        $cek_rb->qty_scaling_1 = !empty($qty_scaling_1) ? $qty_scaling_1 : $cek_rb->qty_scaling_1;
                        $cek_rb->scaling_date_2 = !empty($scaling_date_2) ? $scaling_date_2 : $cek_rb->scaling_date_2;
                        $cek_rb->scaling_time_2 = !empty($scaling_time_2) ? $scaling_time_2 : $cek_rb->scaling_time_2;
                        $cek_rb->qty_scaling_2 = !empty($qty_scaling_2) ? $qty_scaling_2 : $cek_rb->qty_scaling_2;
                        $cek_rb->ship_to_party = !empty($ship_to_party) ? $ship_to_party : $cek_rb->ship_to_party;
                        $cek_rb->delivery_order_no = !empty($delivery_order_no) ? $delivery_order_no : $cek_rb->delivery_order_no;
                        $cek_rb->from_storage_location = !empty($from_storage_location) ? $from_storage_location : $cek_rb->from_storage_location;
                        $cek_rb->upto_storage_location = !empty($upto_storage_location) ? $upto_storage_location : $cek_rb->upto_storage_location;
                        $cek_rb->truck_type = !empty($truck_type) ? $truck_type : $cek_rb->truck_type;
                        $cek_rb->reservation_no = !empty($reservation_no) ? $reservation_no : $cek_rb->reservation_no;
                        $cek_rb->sales_order_no = !empty($sales_order_no) ? $sales_order_no : $cek_rb->sales_order_no;
                        $cek_rb->quotation_no = !empty($quotation_no) ? $quotation_no : $cek_rb->quotation_no;
                        $cek_rb->upto_plant = !empty($upto_plant) ? $upto_plant : $cek_rb->upto_plant;
                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $cek_rb->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $cek_rb->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $cek_rb->status_timbang_3 = $status_timbang;
                        } else {
                            $cek_rb->status_timbang_4 = $status_timbang;
                        }

                        $cek_rb->direction = !empty($direction) ? $direction : $cek_rb->direction;
                        $cek_rb->scaling_date_3 = !empty($scaling_date_3) ? $scaling_date_3 : $cek_rb->scaling_date_3;
                        $cek_rb->scaling_time_3 = !empty($scaling_time_3) ? $scaling_time_3 : $cek_rb->scaling_time_3;
                        $cek_rb->qty_scaling_3 = !empty($qty_scaling_3) ? $qty_scaling_3 : $cek_rb->qty_scaling_3;
                        $cek_rb->scaling_date_4 = !empty($scaling_date_4) ? $scaling_date_4 : $cek_rb->scaling_date_4;
                        $cek_rb->scaling_time_4 = !empty($scaling_time_4) ? $scaling_time_4 : $cek_rb->scaling_time_4;
                        $cek_rb->qty_scaling_4 = !empty($qty_scaling_4) ? $qty_scaling_4 : $cek_rb->qty_scaling_4;
                        $cek_rb->update();

                        $ts = new TrackStatus();
                        $ts->plant = $plant;
                        $ts->sequence = $sequence;
                        $ts->arrival_date = $arrival_date;
                        $ts->status = $next_status;
                        $ts->save();

                        $log = new LogBarierGate();
                        $log->plant = $plant;
                        $log->sequence = $sequence;
                        $log->truck_no = $truck_no;
                        $log->arrival_date = $arrival_date;
                        $log->arrival_time = $arrival_time;
                        $log->type_scenario = $type_scenario;
                        $log->vendor_do = $vendor_do;
                        $log->jenis_kendaraan = $jenis_kendaraan;
                        $log->status = $next_status;
                        $log->next_status = $next_status;
                        $log->scaling_date_1 = $scaling_date_1;
                        $log->scaling_time_1 = $scaling_time_1;
                        $log->qty_scaling_1 = $qty_scaling_1;
                        $log->scaling_date_2 = $scaling_date_2;
                        $log->scaling_time_2 = $scaling_time_2;
                        $log->qty_scaling_2 = $qty_scaling_2;
                        $log->ship_to_party = $ship_to_party;
                        $log->delivery_order_no = $delivery_order_no;
                        $log->from_storage_location = $from_storage_location;
                        $log->upto_storage_location = $upto_storage_location;
                        $log->truck_type = $truck_type;
                        $log->reservation_no = $reservation_no;
                        $log->sales_order_no = $sales_order_no;
                        $log->quotation_no = $quotation_no;
                        $log->upto_plant = $upto_plant;
                        $log->body_sap = $body_sap;
                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $log->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $log->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $log->status_timbang_3 = $status_timbang;
                        } else {
                            $log->status_timbang_4 = $status_timbang;
                        }
                        $log->direction = $direction;
                        $log->scaling_date_3 = $scaling_date_3;
                        $log->scaling_time_3 = $scaling_time_3;
                        $log->qty_scaling_3 = $qty_scaling_3;
                        $log->scaling_date_4 = $scaling_date_4;
                        $log->scaling_time_4 = $scaling_time_4;
                        $log->qty_scaling_4 = $qty_scaling_4;
                        $log->code_bg = $cek_rb->code_bg;
                        $log->date_at = date('Y-m-d');
                        $log->save();

                        DB::commit();

                        try {
                            return response()->json([
                                'status' => 'success',
                                'message'   => 'Data has been successfully updated!',
                            ], 200);
                        } finally {
                            Http::post("{$api_url}/real-time", [
                                'status'  => $next_status,
                                'wb'  => null,
                                'open_gate'  => null,
                                'direction' => null,
                                'from'    => 'SAP',
                                'wb_condition'  => null,
                                'antrian' => true,
                                'data_antrian' => [$plant, $sequence, $arrival_date]
                            ]);
                        }
                    } else {
                        $log = new LogBarierGate();
                        $log->plant = $plant;
                        $log->sequence = $sequence;
                        $log->truck_no = $truck_no;
                        $log->arrival_date = $arrival_date;
                        $log->po = $po;
                        $log->sppb_no = $sppb_no;
                        $log->material = $material;
                        $log->arrival_time = $arrival_time;
                        $log->type_scenario = $type_scenario;
                        $log->vendor_do = $vendor_do;
                        $log->jenis_kendaraan = $jenis_kendaraan;
                        $log->status = $next_status;
                        $log->next_status = $next_status;
                        $log->scaling_date_1 = $scaling_date_1;
                        $log->scaling_time_1 = $scaling_time_1;
                        $log->qty_scaling_1 = $qty_scaling_1;
                        $log->scaling_date_2 = $scaling_date_2;
                        $log->scaling_time_2 = $scaling_time_2;
                        $log->qty_scaling_2 = $qty_scaling_2;
                        $log->ship_to_party = $ship_to_party;
                        $log->delivery_order_no = $delivery_order_no;
                        $log->from_storage_location = $from_storage_location;
                        $log->upto_storage_location = $upto_storage_location;
                        $log->truck_type = $truck_type;
                        $log->reservation_no = $reservation_no;
                        $log->sales_order_no = $sales_order_no;
                        $log->quotation_no = $quotation_no;
                        $log->upto_plant = $upto_plant;
                        $log->body_sap = $body_sap;
                        if (!empty($scaling_date_1) && !empty($scaling_time_1) && !empty($qty_scaling_1)) {
                            $log->status_timbang = $status_timbang;
                        } else if (!empty($scaling_date_2) && !empty($scaling_time_2) && !empty($qty_scaling_2)) {
                            $log->status_timbang_2 = $status_timbang;
                        } else if (!empty($scaling_date_3) && !empty($scaling_time_3) && !empty($qty_scaling_3)) {
                            $log->status_timbang_3 = $status_timbang;
                        } else {
                            $log->status_timbang_4 = $status_timbang;
                        }
                        $log->direction = $direction;
                        $log->scaling_date_3 = $scaling_date_3;
                        $log->scaling_time_3 = $scaling_time_3;
                        $log->qty_scaling_3 = $qty_scaling_3;
                        $log->scaling_date_4 = $scaling_date_4;
                        $log->scaling_time_4 = $scaling_time_4;
                        $log->qty_scaling_4 = $qty_scaling_4;
                        $log->code_bg = $cek_rb->code_bg;
                        $log->date_at = date('Y-m-d');
                        $log->save();

                        DB::commit();

                        return response()->json([
                            'status' => 'success',
                            'message'   => 'Log data has been successfully saved!',
                        ], 202);
                    }
                } else {
                    DB::rollback();

                    return response()->json([
                        'status' => 'error',
                        'message'   => 'Plant or sequence or arrival date. is not found, please register first!',
                    ], 422);
                }
            }
        } catch (QueryException $th) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message'   => $th->getMessage(),
            ], 422);
        }
    }
}
