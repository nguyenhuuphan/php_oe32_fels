<?php

namespace App\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected $model;

    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }
    
    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model) {
            throw new Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function where($condition, $operator = null, $value = null)
    {
        if (func_num_args() == 2) {
            list($value, $operator) = [$operator, '='];
        }
        return $this->model->where($condition, $operator, $value)->get();
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function update(array $input, $id)
    {
        $model = $this->model->findOrFail($id);
        $model->fill($input);
        $model->save();
        return $this;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
