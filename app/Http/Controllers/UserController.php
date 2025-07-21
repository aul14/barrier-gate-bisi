<?php

namespace App\Http\Controllers;

use App\Models\LogUser;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = User::orderBy('users.id', 'DESC')->select('*');
            return DataTables::of($user)
                ->addColumn('action', function ($user) {
                    return view('datatable-modal._action', [
                        'row_id' => $user->id,
                        'edit_url' => route('users.update', $user->id),
                        'delete_url' => route('users.destroy', $user->id),
                        'log_url' => route('users.log', $user->id),
                    ]);
                })

                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            if ($request->password) {
                $validate = [
                    'username'       => 'min:3|unique:users,username,' . $id,
                    'email'     => 'email|unique:users,email,' . $id,
                    'password'     => 'min:5',
                    'confirm_password'     => 'same:password',
                ];
            } else {
                $validate = [
                    'username'       => 'min:3|unique:users,username,' . $id,
                    'email'     => 'email|unique:users,email,' . $id,
                ];
            }

            $validator = Validator::make($request->all(), $validate);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message'   => $validator->messages()->first(),
                ]);
            }

            $us = User::find($id);
            $us->fullname = !empty($request->fullname) ? $request->fullname : $us->fullname;
            $us->username = !empty($request->username) ? $request->username : $us->username;
            $us->email = !empty($request->email) ? $request->email : $us->email;
            if ($request->password) {
                $us->password = $request->password;
            }
            $us->role = !empty($request->role) ? $request->role : $us->role;
            $us->default_wb = !empty($request->default_wb) ? $request->default_wb : $us->default_wb;
            $us->update();

            return response()->json([
                'status' => 'success',
                'message'   => 'Data has been successfully updated!',
            ], 202);
        } catch (QueryException $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                ],
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $th->getMessage(),
                ],
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index')->with('success', 'User has been deleted!');
    }

    public function log(Request $request, $id)
    {
        if ($request->ajax()) {
            $log = LogUser::with('user')->where('user_id', $id)->select('*');
            return DataTables::of($log)
                ->addColumn('active', function ($log) {
                    return $log->is_active ? 'Login' : 'Logout';
                })
                ->rawColumns(['active'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('users.log', compact('id'));
    }
}
