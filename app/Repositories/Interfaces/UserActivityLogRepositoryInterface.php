<?php

namespace App\Repositories\Interfaces;

interface UserActivityLogRepositoryInterface
{
    /**
     * @param $option
     * @return mixed
     */
    public function userList($option);

    /**
     * @param $id
     * @return mixed
     */
    public function findUserById($id);

    /**
     * @param $userId
     * @return mixed
     */
    public function userLog($userId);
}
