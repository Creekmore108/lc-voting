<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use App\Models\ideas;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatar()
    {
        $firstCharacter = $this->email[0];

        $integerToUse = is_numeric($firstCharacter)
            ? $integerToUse = ord(strtolower($firstCharacter)) - 21
            : $integerToUse = ord(strtolower($firstCharacter)) - 96;
    

        // $randomInteger = rand(1,36);

        return 'https://www.gravatar.com/avatar/'
                .md5($this->email)
                .'?2=200'
                .'&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
                .$integerToUse
                .'.png';
    }
}
