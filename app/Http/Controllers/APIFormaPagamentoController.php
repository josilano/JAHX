<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Facades\FormaPagamentoFacade;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class APIFormaPagamentoController extends Controller
{
    public function apiFormaPagamentos()
    {
        try{
            if (! $user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['user_invalid'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
		    return response()->json(['token_expired'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
		    return response()->json(['token_invalid'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
		    return response()->json(['token_absent'], $e->getStatusCode());
        }
        $formapags = FormaPagamentoFacade::all();
        return response()->json(compact('formapags'), 200);
    }
}
