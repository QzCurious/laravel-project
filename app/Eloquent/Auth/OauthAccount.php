<?php

namespace App\Eloquent\Auth;

use Illuminate\Database\Eloquent\Model;

class OauthAccount extends Model
{
    protected $fillable = [
        'provider',
        'sub',
    ];

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
