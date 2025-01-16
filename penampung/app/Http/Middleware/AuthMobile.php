<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

use App\Models\Customer;
use App\Models\CustomerToken;

class AuthMobile
{
    public function handle(Request $request, Closure $next)
    {
        $token = str_replace('Bearer ', '', $request->header('Authorization'));

        $customerToken = CustomerToken::where('token', $token)->first();
        if ($customerToken != null) {
            $customer = Customer::find($customerToken->customer_id);
            if ($customer == null) {
                return response()->json([
                    'message' => 'Customer not registered'
                ], 404);
            }
            Auth::login($customer);
            return $next($request);
        }

        return response()->json([
            'message' => 'Token not valid'
        ], 404);
    }
}