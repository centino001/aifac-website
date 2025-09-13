<?php

namespace App\Services;

use App\Repositories\Contracts\NewsRepositoryInterface;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class NewsService
{
    protected $repository;

    public function __construct(NewsRepositoryInterface $repository)
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

    public function create(array $data, array $images = [])
    {
        $imageUrls = [];
        foreach ($images as $image) {
            $imageUrls[] = Cloudinary::upload($image->getRealPath())->getSecurePath();
        }
        $data['images'] = json_encode($imageUrls);
        return $this->repository->create($data);
    }

    public function update($id, array $data, array $images = [])
    {
        if (!empty($images)) {
            $imageUrls = [];
            foreach ($images as $image) {
                $imageUrls[] = Cloudinary::upload($image->getRealPath())->getSecurePath();
            }
            $data['images'] = json_encode($imageUrls);
        }
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
} 