<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
	use Sluggable, SoftDeletes;

    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            cache()->forget("__articles");
        });

        self::updating(function ($model) {
            cache()->forget("__articles");
        });

        self::deleting(function ($model) {
            cache()->forget("__articles");
        });
    }

    public function admin()
    {
    	return $this->belongsTo(\App\Admin::class, 'created_by', 'id');
    }
}
