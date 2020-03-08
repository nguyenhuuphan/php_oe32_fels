<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class WordLearnRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\WordLearned';
    }

    public function unLearn(array $array)
    {
        return $this->model->where($array)->delete();
    }
}
