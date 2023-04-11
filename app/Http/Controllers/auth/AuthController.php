<?php

namespace App\Http\Controllers\auth;

use Carbon\Carbon;
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
        //
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
                'last_login'=> Carbon::now(),
            ]);
            // $user->save();

            if(User::where('email', $request->email))
                $user->notify(new UserRegistrationNotice($user));
                // dd($user);
                // User::find(Auth::id());

            return [
                'success' => Response::HTTP_OK,
                'message' => 'Kindly verify your account using the link sent to your email',
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

    public function verifyAccount($code)
    {
       try {
        $code = base64_decode($code);
        $user = User::where('activation_code', $code)->first();
        if($user && $user->active === 1){
            return ['success' => 0,
                    'message' => "Your account has already been activated"
                ];
        }else if(!$user){
            return ['success' => 0,
                    'message' => "Invalid URL, kindly contact the administrator for assistance."
                ];
        }
        User::where('activation_code', $code)->update([
            'active' => 1,
            'email_verified_at' => Carbon::now(),
            'activation_code' => null,
        ]);
        return ['success' => 1,
            'message' => "You have successfully activated your account.",
            'data' => [
                'user' => $user->refresh()
            ]
        ];

       } catch (\Exception $exception) {
        return response()->json([
            'success' => false,
            'message'   => $exception->getMessage(),
        ], Response::HTTP_BAD_REQUEST);
        Log::error($exception->getMessage(), [$exception]);
       }
    }

    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();

            if(empty($user)) {
                return [
                    'success' => Response::HTTP_NOT_FOUND,
                    'message' => 'User not found'
                ];
            }else {
                return [
                    'success' => Response::HTTP_CONTINUE,
                    'message' => 'Success',
                    'data' => [
                        'user' => $user->refresh(),
                        'token'=> $user->createToken('Marjo')->accessToken,
                    ]
                ];
            }
        } catch (\Exception $exception) {
            return response()->json([
                'success'   =>false,
                'message'   => $exception->getMessage(),
            ], Response::HTTP_BAD_REQUEST);

            Log::error($exception->getMessage(), [$exception]);
        }
    }

    public function logout(Request $request){

        $request->user()->tokens()->delete();

        return [
            'success' => Response::HTTP_CONTINUE,
            'message' => "logout success."
        ];
    }
}
