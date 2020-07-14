<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;

class ProductTrasformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'  => (int) $product->id,
            'title'  => (string) $product->name,
            'details'  => (string) $product->description,
            'stock'  => (int) $product->quantity,
            'situation'  => (int) $product->status,
            'picture'  =>  url('img/'.$product->image),
            'seller'  =>  (int) $product->seller_id,
            'creationDate'     => (string) $product->created_at,
            'lastChange'     => (string) $product->updated_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('products.show' , $product->id ),
                ],
                [
                    'rel' => 'product.buyers',
                    'href'=> route('products.buyers.index' , $product->id ),
                ],
                [
                    'rel' => 'product.categories',
                    'href'=> route('products.categories.index' , $product->id ),
                ],
                [
                    'rel' => 'product.transactions',
                    'href'=> route('products.transactions.index' , $product->id ),
                ],

                [
                    'rel' => 'seller',
                    'href'=> route('sellers.show' , $product->seller_id ),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier'  => 'id',
            'title'        => 'name',
            'details'       => 'description',
            'stock'  => 'quantity',
            'situation'     =>  'status',
            'picture'     =>  'image',
            'seller'     =>  'seller_id',
            'creationDate'     =>  'created_at',
            'lastChange'     =>  'updated_at',
        ];

        return isset($attribute[$index])? $attribute[$index] : null ;
    }
}
