<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class FollowerRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Follower';
    }
}
