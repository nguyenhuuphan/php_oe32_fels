<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class LessonRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Lesson';
    }
}
