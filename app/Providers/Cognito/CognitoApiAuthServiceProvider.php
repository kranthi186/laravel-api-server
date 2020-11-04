<?php

namespace App\Providers\Cognito;

use App\Cognito\Api\CognitoGuard;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Cognito\CognitoClient;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Support\Arr;
use App\Models\User;

class CognitoApiAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->singleton(CognitoClient::class, function (Application $app) {
            $config = [
                'region'      => config('cognito.region'),
                'version'     => config('cognito.version'),
            ];

            $credentials = config('cognito.credentials');

            if (! empty($credentials['key']) && ! empty($credentials['secret'])) {
                $config['credentials'] = Arr::only($credentials, ['key', 'secret', 'token']);
            }

            return new CognitoClient(
                new CognitoIdentityProviderClient($config),
                config('cognito.app_client_id'),
                config('cognito.app_client_secret'),
                config('cognito.user_pool_id')
            );
        });

        Auth::viaRequest('cognito-token', function ($request) {
            $cognitoClient = app()->make(CognitoClient::class);
            $user = null;
            $token = $request->bearerToken();
            if(! empty($token)) {
                $email = $cognitoClient->getUser($token);
                $user = User::where('email', $email)->first();
            }
            return $user;
        });
    }
}
