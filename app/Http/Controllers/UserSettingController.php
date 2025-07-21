<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserSettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::orderBy('id', 'DESC')->select('*');
            return DataTables::of($user)
                ->addColumn('action', function ($user) {
                    return view('datatable-modal._action', [
                        'row_id' => $user->id,
                        'edit_url' => route('user.edit', $user->id),
                        'delete_url' => route('user.destroy', $user->id),
                    ]);
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('user_setting.index');
    }
}