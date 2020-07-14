<?php

namespace App;

use App\Transformers\TransactionTrasformer;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'quantity', 'buyer_id', 'product_id'
    ];
    public $transformer = TransactionTrasformer::class;

    public function buyer()
    {
        return $this->belongsTo('App\Buyer');
    }

    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
