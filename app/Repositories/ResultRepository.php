<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class ResultRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Result';
    }
}
