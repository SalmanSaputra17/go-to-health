<?php

namespace App\Repositories\Interfaces;

interface ArticleRepositoryInterface
{
    /**
     * @param $option
     * @return mixed
     */
    public function all($option);

    /**
     * @param $request
     * @return mixed
     */
    public function create($request);

    /**
     * @param $id
     * @return mixed
     */
    public function findById($id);

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id);

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id);
}
