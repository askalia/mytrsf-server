<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Response;
use JWTAuth;
use Monolog\Logger;
use Tymon\JWTAuth\Exceptions\JWTException;



class AuthenticateController extends Controller
{
    public function __construct()
    {

        //print_r(get_class_methods(app('log')));
        $this->middleware('jwt.auth', ['except' => ['authenticate', 'signupUser']]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try
        {
            if (! $token = JWTAuth::attempt($credentials))
            {
                return response()->json(['error' => 'invalid_credentials'], Response::HTTP_UNAUTHORIZED);

            }
        }
        catch (JWTException $e)
        {
            return response()->json(['error' => 'could_not_create_token'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(compact('token'), Response::HTTP_OK);
    }
    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate())
            {
                return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
            }
        }
        catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e)
        {
            return response()->json(['token_expired'], $e->getStatusCode());
        }
        catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e)
        {
            return response()->json(['token_invalid'], $e->getStatusCode());

        }
        catch (Tymon\JWTAuth\Exceptions\JWTException $e)
        {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));

    }

    public function signupUser()
    {
        $credentials = \Input::only('email', 'password');
        $credentials['password'] = \Hash::make($credentials['password']);
        try {
            $user = User::create($credentials);
        }
        catch (Exception $e)
        {
            return response()->json(['error' => 'user_already_exists'], Response::HTTP_CONFLICT);
        }
        //$token = JWTAuth::fromUser($user);
        //return response()->json(compact('token'), Response::HTTP_OK);
        return response()->json('OK', Response::HTTP_OK);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $listUsers = User::all();
        return $listUsers;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
