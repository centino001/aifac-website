<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProjectService
{
    protected $repository;

    public function __construct(ProjectRepositoryInterface $repository)
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

    public function create(array $data, $image = null)
    {
        if ($image) {
            $data['image_url'] = Cloudinary::upload($image->getRealPath())->getSecurePath();
        }
        // Assuming description is already formatted
        return $this->repository->create($data);
    }

    public function update($id, array $data, $image = null)
    {
        if ($image) {
            $data['image_url'] = Cloudinary::upload($image->getRealPath())->getSecurePath();
        }
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }

    public function getDonatedAmount($projectId)
    {
        $donations = $this->repository->getDonations($projectId);
        return $donations->sum('amount');
    }
} 