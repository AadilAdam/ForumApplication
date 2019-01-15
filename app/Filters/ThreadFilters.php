<?php
namespace App\Filters;
use App\User;
class ThreadFilters extends Filters
{
    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected $filters = ['by', 'popularity', 'unanswered'];
    /**
     * Filter the query by a given username.
     *
     * @param  string $username
     * @return Builder
     */
    protected function by($username)
    {

        $user = User::where('name', $username)->firstOrFail();
        
        return $this->builder->where('user_id', $user->id);
    }

    /**
     * Filter the query by popularity.
     *
     * @param  string $popularity
     * @return Builder
     */
    protected function popular($username)
    {
        $this->builder->getQuery()->orders = [];

        return $this->builder->orderBy('replies_count', 'desc');

    }

    /**
     * Filter the query by unanswered threads.
     *
     * @param  string $unaswered
     * @return Builder
     */
    protected function unanswered($username)
    {

        return $this->builder->where('replies_count', 0);

    }
}