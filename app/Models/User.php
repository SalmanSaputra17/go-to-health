<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
	use Notifiable, HasApiTokens;

    protected $table = 'users';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id', 'username', 'gender', 'date_of_birth', 'email', 'password',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function generateUID()
    {
        $model = self::count();

        return strtoupper("UID-" . self::makeLoop($model) . \Str::random(3));
    }

    public static function makeLoop($num)
    {
        $result = str_pad($num + 1, 7, 0, STR_PAD_LEFT);

        return $result;
    }

	public function logActivity()
	{
		return $this->hasMany(UserActivityLog::class, 'user_id', 'id');
	}
}
