<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class RoleAuthorizationApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        try {
            //Access token from the request        
            $token = JWTAuth::parseToken();        //Try authenticating user       
            $user = $token->authenticate();
        } catch (TokenExpiredException $e) {        //Thrown if token has expired        
            return $this->unauthorized('Seu token expirou. Por favor faça login novamente.');    
        } catch (TokenInvalidException $e) {        //Thrown if token invalid
            return $this->unauthorized('Seu token é inválido. Por favor faça login novamente.');    
        }catch (JWTException $e) {        //Thrown if token was not found in the request.
            return $this->unauthorized('Por favor, anexe um token de portador ao seu pedido');
        }    //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
        if ($user && in_array($user->profile, explode('|', $roles))) {
            return $next($request);
        } 
    
        return $this->unauthorized();
    }
    
    private function unauthorized($message = null){
        return response()->json([
            'message' => $message ? $message : 'Você não está autorizado a acessar este recurso',
            'success' => false
            ], 401);
    }
}
