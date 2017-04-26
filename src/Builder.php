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
        $clause = $this->determineClause($satisfy);

        $filters = $this->filterParser->parse($query);

        foreach ($filters as $filter) {
            switch ($filter->operator()) {
                case 'in':
                    $this->qb->whereIn(
                        $filter->field(),
                        is_array($filter->value()) ? $filter->value() : [$filter->value()]
                    );
                    break;
                case 'nin':
                    $this->qb->whereNotIn(
                        $filter->field(),
                        is_array($filter->value()) ? $filter->value() : [$filter->value()]
                    );
                    break;
                case 'null':
                    $this->qb->whereNull($filter->field());
                    break;
                case 'nnull':
                    $this->qb->whereNotNull($filter->field());
                    break;
                case 'date':
                    $this->qb->whereDate($filter->field(), $filter->value());
                    break;
                case 'btw':
                    $this->qb->whereBetween(
                        $filter->field(),
                        is_array($filter->value()) ? $filter->value() : [$filter->value()]
                    );
                    break;
                case 'nbtw':
                    $this->qb->whereNotBetween(
                        $filter->field(),
                        is_array($filter->value()) ? $filter->value() : [$filter->value()]
                    );
                    break;
                default:
                    $this->qb->$clause(
                        $filter->field(),
                        $filter->operator(),
                        $filter->value()
                    );
                    break;
            }
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

    protected function determineClause($satisfy)
    {
        return $satisfy == 'any' ? 'orWhere' : 'where';
    }
}
