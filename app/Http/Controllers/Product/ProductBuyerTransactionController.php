<?php

namespace App\Http\Controllers\Product;

use App\Product;
use App\Transaction;
use App\Transformers\ProductTrasformer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
        Parent::__construct();

        $this->middleware('transform.input:' . ProductTrasformer::class)->only(['store']);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request ,Product $product, User $buyer)
    {
        $rules = [
            'quantity'  => 'required|integer|min:1'
        ];
        $this->validate($request,$rules);

        //make sure buyer is different from seller
        if ($buyer->id == $product->seller_id)
        {
            return $this->errorResponse('The buyer must be different from the seller',409);
        }

        //make sure buyer is verified user
        if (!$buyer->isVerified())
        {
            return $this->errorResponse('The buyer must be verified user',409);
        }

        //make sure seller is verified user
        if (!$product->seller->isVerified())
        {
            return $this->errorResponse('The seller must be verified user',409);
        }

        //make sure product is available
        if (!$product->isAvailable())
        {
            return $this->errorResponse('The product is not available',409);
        }

        //make sure quantity of product is equal to transaction quantity
        if ($product->quantity < $request->quantity)
        {
            return $this->errorResponse('The product does not have enough units for this transaction',409);
        }

        return DB::transaction(function ()use ($request , $buyer , $product){
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id'=> $product->id
            ]);

            return $this->showOne($transaction , 201);
        });


    }



}
