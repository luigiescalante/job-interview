<?php

namespace App\Http\Controllers;

use App\Models\Users\Users;
use App\Models\Users\UsersRepository;
use Illuminate\Http\Request;
use App\Models\ApiResponse;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = new UsersRepository();
            $user = $user->login($request->get('user'),
                $request->get('password'));
            if (empty($user)) {
                return ApiResponse::error('Invalid user or password');
            }
            $token = [
                'id'        => $user->id,
                'user'      => $user->user_name,
                'api-token' => $user->api_token,
            ];

            return ApiResponse::success($token);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage());
        }
    }
}
