<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Http\Requests\AdminRegisterRequest;
use App\Http\Resources\AdminResource;
use App\Services\V1\Auth\AdminAuthService;

class AdminAuthController extends Controller
{

    protected $adminAuthService;

    public function __construct(AdminAuthService $adminAuthService)
    {
        $this->adminAuthService = $adminAuthService;
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(AdminRegisterRequest $request)
    {
        return $this->adminAuthService->register($request->only('name', 'email', 'password'));
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function login(AdminLoginRequest $request)
    {
        return $this->adminAuthService->login($request->only('email', 'password'));
    }

    public function logout()
    {
        return $this->adminAuthService->logout();
    }

    public function getUser()
    {
        return  $this->adminAuthService->getUser();
    }
}
