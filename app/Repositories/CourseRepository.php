<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class CourseRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Course';
    }
}
