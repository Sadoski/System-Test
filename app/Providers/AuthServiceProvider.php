<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is_admin', function ($user) {
            return $user->profile=='ADMINISTRADOR'
                        ? true
                        : false;
        });

        Gate::define('is_admin_api', function ($user) {
            try {
                //Access token from the request        
                $token = JWTAuth::parseToken();        //Try authenticating user       
                $user = $token->authenticate();
            } catch (TokenExpiredException $e) {        //Thrown if token has expired        
                return false;    
            } catch (TokenInvalidException $e) {        //Thrown if token invalid
                return false;
            }catch (JWTException $e) {        //Thrown if token was not found in the request.
                return false;
            }    //If user was authenticated successfully and user is in one of the acceptable roles, send to next request.
            
            return $user->profile=='ADMINISTRADOR'
                        ? true
                        : false;
        });
    }
}
