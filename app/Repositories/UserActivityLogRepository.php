<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserActivityLog;
use App\Repositories\Interfaces\UserActivityLogRepositoryInterface;

class UserActivityLogRepository implements UserActivityLogRepositoryInterface
{
	public function userList($option)
	{
		$field = User::select('*');

		return $option == 'all' ? $field->orderBy('username', 'asc')->get() : $field;
	}

	public function findUserById($id)
	{
		return User::findOrFail($id);
	}

	public function userLog($userId)
	{
		return UserActivityLog::select('*')->whereUserId($userId);
	}
}