<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class QuestionRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Question';
    }
}
