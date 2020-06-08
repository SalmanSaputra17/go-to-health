<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public static function boot()
    {
    	parent::boot();

    	self::creating(function ($model) {
            cache()->forget("__foods");
        });

        self::updating(function ($model) {
            cache()->forget("__foods");
        });

        self::deleting(function ($model) {
            cache()->forget("__foods");
        });
    }

    public function admin()
    {
    	return $this->belongsTo(\App\Admin::class, 'created_by', 'id');
    }
}
