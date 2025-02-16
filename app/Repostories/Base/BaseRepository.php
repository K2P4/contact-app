<?php

namespace App\Repostories\Base;

class BaseRepository
{

    protected $model;


    public function __construct($model)
    {

        $this->model = $model;
    }


    public function all()
    {
        return $this->model->all();
    }

    public function query()
    {
        return $this->model->query();
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
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
            return $record;
        }
    }


    public function filterCategory($query, $filters)
    {


        //if filters array has category, we should combine the query
        if (isset($filters['category'])) {
            $query->whereHas('category', function ($catQuery) use ($filters) {
                $catQuery->where('name', $filters['category']);
            });
        }

        return $query;
    }

    public function delete($id)
    {
        $record = $this->model->find($id);
        return $record ? $record->delete() : false;
    }
}
