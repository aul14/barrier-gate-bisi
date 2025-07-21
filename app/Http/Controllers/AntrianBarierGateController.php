<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RealBarier;
use Illuminate\Http\Request;

class AntrianBarierGateController extends Controller
{
    public function index(Request $request)
    {
        return view('antrian.index');
    }

    public function ajax_data_queue(Request $request)
    {
        $data = [];
        if ($request->ajax()) {
            $data = RealBarier::whereBetween('created_at', [now()->subDays(2)->startOfDay(), now()->endOfDay()])->where(function ($query) {
                $query->where('next_status', 'please do scale 1')->orWhere('next_status', 'please do scale 2')->orWhere('next_status', 'please do scale 3')->orWhere('next_status', 'please do scale 4');
            })->orderBy('id', 'DESC')->paginate(16);
        }
        return response()->json([
            'data' => $data->items(),
            'pagination_links' => $data->links()->toHtml(),
            'total_pages' => $data->lastPage(),
        ]);
    }
}
