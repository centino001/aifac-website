<?php

namespace App\Repositories\Eloquent;

use App\Models\News;
use App\Repositories\Contracts\NewsRepositoryInterface;

class NewsRepository implements NewsRepositoryInterface
{
    protected $model;

    public function __construct(News $model)
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
        $news = $this->find($id);
        $news->update($data);
        return $news;
    }

    public function delete($id)
    {
        $news = $this->find($id);
        $news->delete();
    }
} 