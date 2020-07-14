<?php

namespace App;


use App\Transformers\BuyerTransformer;
use Illuminate\Database\Eloquent\Model;

class Buyer extends User
{

    public $transformer = BuyerTransformer::class;

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
