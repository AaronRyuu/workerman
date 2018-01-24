<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * 用户头像
     * @return mixed|string
     */
    public function avatar()
    {
        return "https://www.gravatar.com/avatar/" . md5(strtolower($this->email)) . "?d=retro&s=64";
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }
}
