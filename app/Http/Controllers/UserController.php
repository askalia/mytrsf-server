<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Entities\User;
use Illuminate\Http\Response;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

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
    public function update(Request $request)
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
        }
        $this->validate($request, User::getValidators());

        // store
        //$user = User::find($id);
        $getParams = \Input::all();
        foreach ($getParams as $getProp => $value)
        {
            if ($user->{$getProp} != $getProp)
            {
                $user->{$getProp} = $value;
            }
        }
        $user->save();

        $toast = 'profile_update_success';

        return response()->json(compact('toast', 'user'), Response::HTTP_OK);
    }

    public function getInventory()
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
        }
        return response()->json($user->products()->getResults(), Response::HTTP_OK);
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
