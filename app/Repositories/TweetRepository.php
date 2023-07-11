<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Tweet;

class TweetRepository
{
    /**
     * @var Tweet
     */
    private Tweet $model;

    /**
     * @param Tweet $model
     */
    public function __construct(Tweet $model)
    {
        $this->model = $model;
    }

    /**
     * Store Tweet
     *
     * @param array $data
     * @return Tweet
     */
    public function create(array $data)
    {
        $eloquent = $this->model->create($data);
        return $eloquent;
    }

    /**
     * Get Tweet
     *
     * @param int $data
     * @return Tweet
     */
    public function find($id)
    {
        $eloquent = $this->model->find($id);
        return $eloquent;
    }

    /**
     * Upate Tweet
     *
     * @param Tweet $model
     * @param array $data
     * @return Tweet
     */
    public function update($model, array $data)
    {
        $eloquent = $model->update($data);
        return $eloquent;
    }

    /**
     * Delete Tweet
     *
     * @param integer $id
     * @return void
     */
    public function destroy(int $id)
    {
        $eloquent = $this->find($id);
        $eloquent->delete();
    }
}
