<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unique_id',
        'username',
        'gender',
        'date_of_birth',
        'email',
        'password',
        'active',
        'activation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'activation_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = ['deleted_at'];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            cache()->forget("__users");
        });

        self::updating(function ($model) {
            cache()->forget("__users");
        });

        self::deleting(function ($model) {
            cache()->forget("__users");
        });
    }

    /**
     * @return string
     */
    public static function generateUID()
    {
        $model = self::count();

        return strtoupper("UID-" . self::makeLoop($model) . \Str::random(3));
    }

    /**
     * @param $num
     * @return string
     */
    public static function makeLoop($num)
    {
        $result = str_pad($num + 1, 7, 0, STR_PAD_LEFT);

        return $result;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logActivity()
    {
        return $this->hasMany(UserActivityLog::class, 'user_id', 'id');
    }
}
