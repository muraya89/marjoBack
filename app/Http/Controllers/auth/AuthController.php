<?php

namespace App\Http\Controllers\auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\UserRegistrationNotice;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->users();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'email'=> 'required|unique:users,email',
                'phone_number' => 'required',
                'id_number' => 'required|integer',
                'password'=>'required|min:8',
            ]);
            $user = User::create([
                "email"=> $request->email,
                "first_name"=> $request->first_name,
                "id_number"=> $request->id_number,
                "last_name"=> $request->last_name,
                "password"=> Hash::make( $request->password ),
                "phone_number"=> $request->phone_number,
                'activation_code' => mt_rand(9,9999),
                'ip_address'=> $request->getClientIp(),
            ]);
            // $user->save();

            if(User::where('email', $request->email))
                $user->notify(new UserRegistrationNotice($user));
                // dd($user);
                // User::find(Auth::id());

            return [
                'success' => Response::HTTP_OK,
                'message' => 'Kindly confirm your email address using the link sent to your account',
                'data' => [
                    'user' => $user->refresh(),
                    'token'=> $user->createToken('Marjo')->accessToken,
                ]
            ];
        } catch (\Exception $e) {
            return response()->json([
                'success'   =>false,
                'message'   => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);

            Log::error($e->getMessage(), [$e]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
