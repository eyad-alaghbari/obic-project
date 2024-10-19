<?php

namespace App\Services\V1\Auth;

use App\Models\User;
use App\Trait\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AdminResource;

class AdminAuthService
{
    use ApiResponseTrait;

    /**
     * Creates a new admin and returns a token
     *
     * @param array $data
     * @return JsonResponse
     */
    public function register($data)
    {
        $data['password'] = bcrypt($data['password']);
        $admin = User::create($data);

        if (!$admin) {
            return $this->ErrorResponse('خطأ في انشاء المستخدم', 500);
        }


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $admin,
            'token' => JWTAuth::fromUser($admin),
        ], 201);
    }

    /**
     * Logs in an admin and returns a token
     *
     * @param array $credentials
     * @return JsonResponse
     */
    public function login($credentials)
    {
        if (!$token = Auth::guard('admin')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $responsWithToken = $this->respondWithToken($token);

        return $this->loginResponse($responsWithToken, $token);
    }

    /**
     * Logs out an admin and invalidates the token
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Returns the current admin user
     *
     * @return JsonResponse
     */
    public function getUser()
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        return $this->SuccessResponse(AdminResource::make($user), 'تم الحصول على بيانات المستخدم الحالي', 200);
    }

    /**
     * Creates a response with a token
     *
     * @param string $token
     * @return array
     */
    protected function respondWithToken(): array
    {
        return [
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('admin')->factory()->getTTL() * 60,
            'user' => AdminResource::make(Auth::guard('admin')->user()) // بيانات المستخدم الحالي
        ];
    }
}
