<?php

namespace App\Repositories\Eloquent;

use App\Models\Person;
use App\Repositories\Contracts\PersonRepositoryInterface;

class PersonRepository implements PersonRepositoryInterface
{
    protected $model;

    public function __construct(Person $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $person = $this->find($id);
        $person->update($data);
        return $person;
    }

    public function delete($id)
    {
        $person = $this->find($id);
        $person->delete();
    }
} 