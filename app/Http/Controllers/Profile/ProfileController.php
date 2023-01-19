<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function index()
    {
        try{
            return [
                'success' => Response::HTTP_OK,
                'message' => 'success',
                'data' => Auth::user()
            ];
        }catch(\Exception $e) {
            return response()->json([
                'success'   =>false,
                'message'   => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);

            Log::error($e->getMessage(), [$e]);
        }

    }
}
