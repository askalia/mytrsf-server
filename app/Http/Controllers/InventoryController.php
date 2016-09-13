<?php

namespace App\Http\Controllers;

use App\Entities\ProductUser;
use App\Entities\User;
use App\Entities\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class InventoryController extends Controller
{

    const ATTACH =1;
    const DETACH = 0;
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
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
        }
        if ($request->get('attachment')== '1')
        {
            $response = $this->importToInventory($request->get('asin'));
        }
        else {
            $response = $this->removeFromInventory($request->get('asin'));
        }
        return $response;
    }

    /**
     * @param User $_user
     * @param $productRef   ASIN reference
     * @return \Illuminate\Http\JsonResponse
     */
    private function importToInventory($_productRef)
    {
        try {

            DB::transaction(function() use ($_productRef)
            {
                if (!$user = JWTAuth::parseToken()->authenticate())
                {
                    return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
                }

                $productFinder = app('ProductFinder');
                $selectedProduct = $productFinder->lookupItem($_productRef, $user->lang, $user->id);

                $selectedProduct->save();


                if ($user->products()->where('product_id', $selectedProduct->id)->get()->isEmpty())
                {
                    $user->products()->attach([ $selectedProduct->id => ['is_shared' => true, 'created_at' => new \DateTime(), 'updated_at' => new \DateTime()]]);

                }
            });
        }
        catch(QueryException $e)
        {

            $status = 'object_importation_failure';
            $toast = $e->getMessage();
            return response()->json(compact('status', 'toast'), Response::HTTP_CONFLICT);
        }
        $toast = 'object_importation_success';
        return response()->json(compact('toast'), Response::HTTP_OK);


    }
    private function removeFromInventory($_productRef)
    {
        if (!$user = JWTAuth::parseToken()->authenticate())
        {
            return response()->json('user_not_found', Response::HTTP_NOT_FOUND);
        }
        $detachProduct = Product::where('ASIN', '=', $_productRef)->first();
        $user->products()->detach([$detachProduct->id]);
        $toast = 'object_removal_success';
        return response()->json(compact('toast'), Response::HTTP_OK);
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
