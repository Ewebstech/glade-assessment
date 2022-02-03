<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use DomainException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Helpers\Response;
use UnexpectedValueException;
use App\Helpers\HttpStatusCodes;
use Firebase\JWT\ExpiredException;


class JwtMiddleware
{
    use Response;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->header('Authorization');

        if(!$token) {
            return $this->error('Token not provided', HttpStatusCodes::BAD_REQUEST);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        }

        catch(ExpiredException $e) {
            return $this->error('Expired Token', HttpStatusCodes::UNAUTHORIZED);
        }

        catch(UnexpectedValueException $e) {
            return $this->error('Wrong Number of Segments in Token', HttpStatusCodes::BAD_REQUEST);
        }

        catch(DomainException $e) {
            return $this->error('Malformed Token', HttpStatusCodes::BAD_REQUEST);
        }

        catch(Exception $e) {
            return $this->error('Error occured while decoding token', HttpStatusCodes::BAD_REQUEST);
        }

        $userModel = new User;
        $userDetails = $userModel->getUser($credentials->sub);
        if(!$userDetails){
            return $this->error('Unknown Token Details', HttpStatusCodes::UNAUTHORIZED);
        }

        // Now let's put the user in the request class so that you we can grab it from there
        $request->auth = $userDetails;

        return $next($request);
    }
}
