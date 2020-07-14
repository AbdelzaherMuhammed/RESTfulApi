<?php

namespace App\Transformers;

use App\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier'  => (int) $buyer->id,
            'name'        => (string) $buyer->name,
            'email'       => (string) $buyer->email,
            'creationDate'     => (string) $buyer->created_at,
            'lastChange'     => (string) $buyer->updated_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('buyers.show' , $buyer->id ),
                ],
                [
                    'rel' => 'buyer.transactions',
                    'href'=> route('buyers.transactions.index' , $buyer->id ),
                ],
                [
                    'rel' => 'buyer.categories',
                    'href'=> route('buyers.categories.index' , $buyer->id ),
                ],
                [
                    'rel' => 'buyer.products',
                    'href'=> route('buyers.products.index' , $buyer->id ),
                ],
                [
                    'rel' => 'buyer.sellers',
                    'href'=> route('buyers.sellers.index' , $buyer->id ),
                ],
            ]
        ];
    }
    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier'  => 'id',
            'name'        => 'name',
            'email'       => 'email',
            'isVerified'  => 'verified',
            'isAdmin'     =>  'admin' ,
            'creationDate'     =>  'created_at',
            'lastChange'     =>  'updated_at',
        ];

        return isset($attribute[$index])? $attribute[$index] : null ;
    }

}
