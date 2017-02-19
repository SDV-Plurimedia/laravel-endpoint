<?php

namespace SdV\Endpoint;

use SdV\Endpoint\Contracts\FilterParser as Contract;

class FilterParser implements Contract
{
    protected $filtrable = [];

    protected $operatorsMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'neq' => '!=',
    ];

    public function __construct(array $filtrable = [])
    {
        $this->filtrable = $filtrable;
    }

    public function parse(array $filterInput = [])
    {
        $parsedFilters = [];

        foreach ($filterInput as $filter) {
            list($field, $condition, $value) = explode(',', $filter);

            if ($this->isFiltrable($field)) {
                $parsedFilters[] = new Filter(
                    $field,
                    $this->mapToOperator($condition),
                    $value
                );
            }
        }

        return $parsedFilters;
    }

    protected function mapToOperator($condition)
    {
        return isset($this->operatorsMap[$condition])
            ? $this->operatorsMap[$condition]
            : '=';
    }

    protected function isFiltrable($field)
    {
        return in_array($field, $this->filtrable) || empty($this->filtrable);
    }
}
