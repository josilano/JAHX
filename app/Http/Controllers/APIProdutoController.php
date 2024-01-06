<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use App\Facades\ProdutoFacade;
use Tymon\JWTAuth\Exceptions\JWTException;

class APIProdutoController extends Controller
{
    public function apiProdutos()
    {
        try{
            if (! $user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json(['user_not_found'], 404);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
		    return response()->json(['token_expired'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
		    return response()->json(['token_invalid'], $e->getStatusCode());
	    } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
		    return response()->json(['token_absent'], $e->getStatusCode());
        }
        $produtos = ProdutoFacade::all();
        return response()->json(compact('produtos'), 200);
    }
}
