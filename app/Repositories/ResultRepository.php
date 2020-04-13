<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class ResultRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\Result';
    }

    public function deleteOnUser($user_id)
    {
        return $this->model->where('user_id', $user_id)->delete();
    }
}
