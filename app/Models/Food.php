<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Food extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function admin()
    {
    	return $this->belongsTo(\App\Admin::class, 'created_by', 'id');
    }
}
