<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{

    public function model()
    {
        return 'App\Models\User';
    }

    public function paginate($limit)
    {
        return $this->model->orderBy('created_at', 'desc')->paginate($limit);
    }
}
