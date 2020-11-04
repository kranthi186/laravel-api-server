<?php
namespace App\Cognito\Api;

use App\Cognito\CognitoClient;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use App\Models\User;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;

class CognitoGuard
{
    use GuardHelpers;
    /**
     * @var CognitoClient
     */
    protected $client;
    protected $request;
    protected $token;

    /**
     * CognitoGuard constructor.
     * @param string $name
     * @param CognitoClient $client
     * @param UserProvider $provider
     * @param Session $session
     * @param null|Request $request

     */
    public function __construct(
        CognitoClient $client,
        Request $request = null,
        $token = null
    ) {
        $this->client = $client;
        $this->request = $request;
    }

    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;
        $userCognito = null;

        $token = $this->getTokenForRequest();

        if(! empty($token)) {
            try {
                $userCognito = $this->client->getUser([
                    'AccessToken' => $token
                ]);
            } catch (Exception $e) {
                throw $e;
            }

        }

        return $user;
    }

    public function getTokenForRequest()
    {

        $token = $this->request->bearerToken();
        return $token;
    }

    public function validate(array $credentials = [])
    {

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }


    public function setRequest(Request $request)
    {
        $this->request = $request;

        return $this;
    }
}