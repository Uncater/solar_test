<?php

namespace App\Repositories;

class CommentRepository extends Repository
{
    public function model()
    {
        return 'App\Model\Comment';
    }

    public function getAllWithTrashed()
    {
        return $this->model->withTrashed()->get();
    }

}