<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class WordRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Word';
    }
}
