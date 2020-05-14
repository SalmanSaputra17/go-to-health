<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $guarded = [];

	public function logActivity()
	{
		return $this->hasMany(UserActivityLog::class, 'user_id', 'id');
	}
}
