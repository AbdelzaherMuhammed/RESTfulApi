<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    public $transformer = UserTransformer::class;
    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verified', 'verification_token', 'admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }
    public function setNameAttribute($name)
    {
        return $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name)
    {
        return ucwords($name);
    }

    public function setEmailAttribute($email)
    {
        return $this->attributes['email'] = strtolower($email);
    }


    public  function isVerified()
    {
        return $this->verified ==User::VERIFIED_USER;
    }

    public static function generateVerificationToken()
    {
        return Str::random(60);
    }

    public function isAdmin()
    {
        return $this->admin == User::ADMIN_USER;
    }



}
