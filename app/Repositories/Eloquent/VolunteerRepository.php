<?php

namespace App\Repositories\Eloquent;

use App\Models\Volunteer;
use App\Repositories\Contracts\VolunteerRepositoryInterface;

class VolunteerRepository implements VolunteerRepositoryInterface
{
    protected $model;

    public function __construct(Volunteer $model)
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
        $volunteer = $this->find($id);
        $volunteer->update($data);
        return $volunteer;
    }

    public function delete($id)
    {
        $volunteer = $this->find($id);
        $volunteer->delete();
    }

    public function getByProject($projectId)
    {
        return $this->model->where('project_id', $projectId)->get();
    }
} 