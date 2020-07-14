<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transformers\ProductTrasformer;
use Illuminate\Http\Request;


class ProductController extends ApiController
{

    public function __construct()
    {
        Parent::__construct();

        $this->middleware('transform.input:' . ProductTrasformer::class)->only(['store' , 'update']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::all();

        return $this->showAll($product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required|min:25',
            'quantity' => 'required|integer',
            'status' => 'required',
            'image' => 'required|image',
            'seller_id' => 'required|exists:sellers,id',

        ];

        $this->validate($request, $rules);

        $data = $request->all();
        $data['verified'] = Product::UNAVAILABLE_PRODUCT;
        $data['image'] = '1.jpg' ;

        $product = Product::create($data);

        return $this->successResponse($product ,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = product::findOrFail($id);

        return $this->showOne($product);
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'description' => 'min:25',
            'quantity' => 'integer',
            'image' => 'image',
            'seller_id' => 'exists:sellers,id',
        ];

        $this->validate($request, $rules);

        $product = Product::findOrFail($id);

        $product->update($request->all());

        return $this->successResponse($product ,200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
