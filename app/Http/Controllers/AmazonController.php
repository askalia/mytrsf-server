<?php

namespace App\Http\Controllers;

use App\Providers\ProductFinderServiceProvider;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;


class AmazonController extends Controller
{

    public function search()
    {
        $productFinder = app('ProductFinder');
        try {
            $results = $productFinder->find(\Input::get('keyword'), \Input::get('category'));
            return response()->json($results, 200);
        }
        catch (\InvalidArgumentException $e)
        {
            return response()->json($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

       //echo $formattedResponse;
        //var_dump($formattedResponse);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
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
