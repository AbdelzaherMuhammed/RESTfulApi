<?php

namespace App\Transformers;

use App\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTrasformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'product' => (int)$transaction->product_id,
            'buyer' => (int)$transaction->buyer_id,
            'creationDate' => (string)$transaction->created_at,
            'lastChange' => (string)$transaction->updated_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href'=> route('transactions.show' , $transaction->id ),
                ],
                [
                    'rel' => 'buyers',
                    'href'=> route('buyers.show' , $transaction->buyer_id ),
                ],
                [
                    'rel' => 'transaction.categories',
                    'href'=> route('transactions.categories.index' , $transaction->id ),
                ],
                [
                    'rel' => 'products',
                    'href'=> route('products.show' , $transaction->product_id ),
                ],
                [
                    'rel' => 'transaction.sellers',
                    'href'=> route('transactions.sellers.index' , $transaction->id ),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attribute = [
            'identifier' => 'id',
            'quantity' => 'quantity',
            'product' => 'product_id',
            'buyer' => 'buyer_id',
            'creationDate' => 'created_at',
            'lastChange' => 'updated_at',

        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
