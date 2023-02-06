<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    use ApiResponse;

    /**
     * [Description for login]
     *
     * @param LoginRequest $request
     *
     * @return json
     *
     * Created at: 2/4/2023, 11:10:02 AM (America/Bogota)
     * @author     Andres Cantillo Nava
     */
    public function login(LoginRequest $request)
    {

        if (!auth()->attempt($request->all())) {
            return $this->errorResponse('Invalid Credentials',"Credentials do not match please try again",401);
        }

        $user = Auth::user();

        $accessToken = $user->createToken('authToken')->plainTextToken;

        return  $this->successResponse(['user' => auth()->user(), 'access_token' => $accessToken],'Successfully logged in!',200);
    }
}
