<?php

namespace App\Services\V1\Auth;

use App\Trait\ApiResponseTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\customerResource;
use App\Models\Customer;

class CustomerAuthService
{
    use ApiResponseTrait;

    /**
     * Creates a new customer and returns a token
     *
     * @param array $data
     * @return JsonResponse
     */
    public function register($data)
    {
        $data['password'] = bcrypt($data['password']);
        $customer = Customer::create($data);

        if (!$customer) {
            return $this->ErrorResponse('خطأ في انشاء المستخدم', 500);
        }


        return response()->json([
            'message' => 'User successfully registered',
            'user' => $customer,
            'token' => JWTAuth::fromUser($customer),
        ], 201);
    }

    /**
     * Logs in an customer and returns a token
     *
     * @param array $credentials
     * @return JsonResponse
     */
    public function login($credentials)
    {
        if (!$token = Auth::guard('customer')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $responsWithToken = $this->respondWithToken($token);

        return $this->loginResponse($responsWithToken, $token);
    }

    /**
     * Logs out an customer and invalidates the token
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::guard('customer')->logout();

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Returns the current customer user
     *
     * @return JsonResponse
     */
    public function getUser()
    {
        $user = Auth::guard('customer')->user();

        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        return $this->SuccessResponse(CustomerResource::make($user), 'تم الحصول على بيانات المستخدم الحالي', 200);
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
            'expires_in' => Auth::guard('customer')->factory()->getTTL() * 60,
            'user' => customerResource::make(Auth::guard('customer')->user()) // بيانات المستخدم الحالي
        ];
    }
}
