<?php

namespace App\Repository;

use App\User;
use Carbon\Carbon;

class Users
{
    const CACHE_KEY = 'USERS';

    public function all($orderBy)
    {
        $key      = "all.{$orderBy}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function () use ($orderBy) {
            return User::orderby($orderBy)->get();
        });
    }
    public function get($id)
    {
        $key      = "get.{$id}";
        $cacheKey = $this->getCacheKey($key);

        return cache()->remember($cacheKey, Carbon::now()->addMinutes(5), function () use ($id) {
            return User::find($id)->get();
        });
    }

    public function getCacheKey($key)
    {
        $key = strtoupper($key);
        return self::CACHE_KEY . ".{$key}";
    }

}
