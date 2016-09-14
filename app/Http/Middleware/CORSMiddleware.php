<?php

namespace App\Http\Middleware;

use Closure;

class CORSMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
                 'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE',
              
             ];
        if($request->getMethod() == "OPTIONS")
        {
            // The client-side application can set only headers allowed in Access-Control-Allow-Headers
            return Response::make('OK', 200, $headers);
        }
        $response = $next($request);
        foreach($headers as $key => $value){
              $response->header($key, $value);
        }
        return $response;

    }
}
