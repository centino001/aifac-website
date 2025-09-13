<?php

namespace App\Services;

use App\Repositories\Contracts\VolunteerRepositoryInterface;

class VolunteerService
{
    protected $repository;

    public function __construct(VolunteerRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function all()
    {
        return $this->repository->all();
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function getByProject($projectId)
    {
        return $this->repository->getByProject($projectId);
    }
} 