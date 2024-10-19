<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerLoginRequest;
use App\Http\Requests\CustomerRegisterRequest;
use App\Services\V1\Auth\CustomerAuthService;

class CustomerAuthController extends Controller
{

    protected $customerAuthServicee;

    public function __construct(CustomerAuthService $customerAuthServicee)
    {
        $this->customerAuthServicee = $customerAuthServicee;
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(CustomerRegisterRequest $request)
    {
        return $this->customerAuthServicee->register($request->only('name', 'email', 'password'));
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function login(CustomerLoginRequest $request)
    {
        return $this->customerAuthServicee->login($request->only('email', 'password'));
    }

    /**
     * Logout a User.
     * logout
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        return $this->customerAuthServicee->logout();
    }

    /**
     * Get the current User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        return  $this->customerAuthServicee->getUser();
    }
}

