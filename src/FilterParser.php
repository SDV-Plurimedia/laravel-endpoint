<?php

namespace SdV\Endpoint;

use SdV\Endpoint\Contracts\FilterParser as Contract;

class FilterParser implements Contract
{
    protected $filtrable = [];

    protected $operatorsMap = [
        'eq'    => '=',
        'gt'    => '>',
        'lt'    => '<',
        'gte'   => '>=',
        'lte'   => '<=',
        'neq'   => '!=',
        'lk'    => 'like',
        'in'    => 'in',
        'nin'   => 'nin',
        'null'  => 'null',
        'nnull' => 'nnull',
        'btw'   => 'btw',
        'nbtw'  => 'nbtw',
        'date'  => 'date',
    ];

    public function __construct(array $filtrable = [])
    {
        $this->filtrable = $filtrable;
    }

    /**
     * Returns the filters.
     *
     * @param  array  $filterInput
     * @return array[Filter]
     */
    public function parse(array $filterInput = [])
    {
        $parsedFilters = [];

        foreach ($filterInput as $filter) {
            $params = explode(',', $filter);

            if (count($params) == 3) {
                list($field, $condition, $value) = $params;
            } else {
                list($field, $condition) = $params;
                $value = array_slice($params, 2);
            }

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

    /**
     * Determine if the field is filtrable.
     *
     * @param  string  $field
     * @return boolean
     */
    protected function isFiltrable($field)
    {
        return in_array($field, $this->filtrable) || empty($this->filtrable);
    }
}
