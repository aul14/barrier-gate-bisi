<?php

namespace App\Http\Controllers;

// use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'fullname'     => 'required',
                'username'       => 'required|min:3|unique:users,username',
                'email'     => 'required|email|unique:users,email',
                'password'     => 'required|min:5',
                'confirm_password'     => 'required|same:password',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message'   => $validator->messages()->first(),
                ]);
            }

            $us = new User();
            $us->fullname = $request->fullname;
            $us->username = $request->username;
            $us->email = $request->email;
            $us->password = $request->password;
            $us->role = $request->role;
            $us->default_wb = $request->default_wb;
            $us->save();

            return response()->json([
                'status' => 'success',
                'message'   => 'Data has been successfully saved!',
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
}
