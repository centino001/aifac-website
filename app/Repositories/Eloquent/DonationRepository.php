<?php

namespace App\Repositories\Eloquent;

use App\Models\Donation;
use App\Repositories\Contracts\DonationRepositoryInterface;

class DonationRepository implements DonationRepositoryInterface
{
    protected $model;

    public function __construct(Donation $model)
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
        $donation = $this->find($id);
        $donation->update($data);
        return $donation;
    }

    public function delete($id)
    {
        $donation = $this->find($id);
        $donation->delete();
    }

    public function getByProject($projectId)
    {
        return $this->model->where('project_id', $projectId)->get();
    }
} 