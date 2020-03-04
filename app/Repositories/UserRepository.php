<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\User';
    }
}
