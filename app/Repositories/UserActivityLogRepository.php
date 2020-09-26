<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserActivityLog;
use App\Repositories\Interfaces\UserActivityLogRepositoryInterface;

class UserActivityLogRepository implements UserActivityLogRepositoryInterface
{
    /**
     * @param string $option
     * @return mixed
     */
    public function userList($option = 'get')
    {
        $field = User::select('*');

        return $option == 'get' ? $field->orderBy('username', 'asc')->get() : $field;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function findUserById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param $userId
     * @return mixed
     */
    public function userLog($userId)
    {
        return UserActivityLog::select('*')->whereUserId($userId);
    }
}
