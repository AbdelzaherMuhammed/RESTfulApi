<?php

namespace App;

use App\Transformers\ProductTrasformer;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const AVAILABLE_PRODUCT = 'available';
    const UNAVAILABLE_PRODUCT = 'unavailable';

    public $transformer = ProductTrasformer::class;

    protected $fillable = [
        'name' , 'description' , 'quantity' , 'status' , 'image' , 'seller_id'
    ];

    public function isAvailable()
    {
        return $this->status == Product::AVAILABLE_PRODUCT;
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }

    public function seller()
    {
        return $this->belongsTo('App\Seller');
    }

    protected $hidden = ['pivot'];
}
