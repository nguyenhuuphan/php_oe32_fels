<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class AnswerRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Answer';
    }
}
