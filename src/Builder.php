<?php

namespace SdV\Endpoint;

class Builder
{
    public $model;

    public $qb;

    public $filterParser;

    public $sortParser;

    public function __construct($model, FilterParser $filterParser, SortParser $sortParser)
    {
        $this->model = $model;
        $this->filterParser = $filterParser;
        $this->sortParser = $sortParser;
        $this->qb = $model->query();
    }

    public function filter(array $query = [], $satisfy)
    {
        $clause = $satisfy == 'all' ? 'where' : 'orWhere';

        $filters = $this->filterParser->parse($query);

        foreach ($filters as $filter) {
            $this->qb->$clause(
                $filter->field(),
                $filter->operator(),
                $filter->value()
            );
        }

        return $this;
    }

    public function sort($query)
    {
        $sorts = $this->sortParser->parse($query);

        foreach ($sorts as $sort) {
            $this->qb->orderBy(
                $sort->field(),
                $sort->direction()
            );
        }

        return $this;
    }

    public function query()
    {
        return $this->qb;
    }
}
