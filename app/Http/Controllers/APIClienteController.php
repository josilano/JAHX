<?php

namespace App\Http\Controllers;

use JWTAuth;
use App\Facades\ClienteFacade;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class APIClienteController extends Controller
{
    public function apiClientes()
    {
        try{
            if ($user = JWTAuth::parseToken()->authenticate())
            {
                $clientes = ClienteFacade::all();
                return response()->json($clientes, 200);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
		    return response()->json(['token_expired'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
		    return response()->json(['token_invalid'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
		    return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(['error' => 'invalid_token'], 401);
    }
}
