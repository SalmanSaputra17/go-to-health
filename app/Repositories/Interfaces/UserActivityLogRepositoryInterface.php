<?php

namespace App\Repositories\Interfaces;

interface UserActivityLogRepositoryInterface
{
	public function userList($option);

	public function findUserById($id);

	public function userLog($userId);
}