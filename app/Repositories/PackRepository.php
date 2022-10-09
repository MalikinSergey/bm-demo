<?php

namespace App\Repositories;

use App\Models\Pack;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder as QueryBuilder;
use \Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class PackRepository
{
    /**
     * @type Pack
     */
    protected Pack $model;

    /**
     * @type bool
     */
    protected bool $asQuery = false;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function asQuery()
    {
        $this->asQuery = true;

        return $this;
    }

    public function prepareResult($query, $queryMethod = 'get')
    {
        if ($this->asQuery()) {
            return $query;
        } else {
            return $query->{$queryMethod};
        }
    }

    public function getFreebies()
    {
        $query = $this->model->where('purpose', 'freebie');

        return $this->prepareResult($query);
    }

}