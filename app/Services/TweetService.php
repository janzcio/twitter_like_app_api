<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\TweetRepository;
use Illuminate\Support\Facades\Auth;

class TweetService
{
    /**
     * @var TweetRepository
     */
    private TweetRepository $tweetRepository;

    /**
     * @param TweetRepository $tweetRepository
     */
    public function __construct(TweetRepository $tweetRepository)
    {
        $this->tweetRepository = $tweetRepository;
    }

    /**
     *  Store Tweet
     * 
     * @return Tweet
     */
    public function create(array $data)
    {        
        return $this->tweetRepository->create($data);
    }

    /**
     *  Get Tweet by id
     * 
     * @return Boolean
     */
    public function find(int $id)
    {
        return $this->tweetRepository->find($id);
    }

    /**
     * Upate tweet
     *
     * @param Tweet $model
     * @param array $data
     * @return Tweet
     */
    public function update($model, array $data)
    {        
        return $this->tweetRepository->update($model, $data);
    }

    /**
     * Delete Tweet
     *
     * @param integer $id
     * @return void
     */
    public function delete(int $id)
    {        
        return $this->tweetRepository->destroy($id);
    }
}
