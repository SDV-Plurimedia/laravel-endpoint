<?php

namespace SdV\Endpoint;

trait Filtrable
{
    /**
     * The operators for filtering.
     *
     * @var array
     */
    protected static $operatorsMap = [
        'eq' => '=',
        'gt' => '>',
        'lt' => '<',
        'gte' => '>=',
        'lte' => '<=',
        'neq' => '!=',
    ];

    /**
     * Perform filtering against the model's data.
     *
     * @param  string  $query The filter query string
     * @param  string  $satisfy
     * @return Builder
     */
    public static function filter($filterQuery, $satisfy = 'all', $sortQuery = 'null')
    {
        $whereClause = $satisfy == 'all' ? 'where' : 'orWhere';

        $builder = (new static)->query();

        // Filter
        if (!is_null($filterQuery)) {
            $filters = static::parseFilterQuery($filterQuery);

            foreach ($filters as $filter) {
                $builder->$whereClause($filter['field'], $filter['operator'], $filter['value']);
            }
        }

        // Sort
        if (!is_null($sortQuery)) {
            $sorts = static::parseSortQuery($sortQuery);

            foreach ($sorts as $sort) {
                $builder->orderBy($sort['field'], $sort['order']);
            }
        }

        return $builder;
    }

    /**
     * Map query string operator with the eloquent operator.
     *
     * @param  string $operator
     * @return string
     */
    public static function mapOperator($operator)
    {
        return isset(static::$operatorsMap[$operator])
            ? static::$operatorsMap[$operator]
            : '=';
    }

    /**
     * Parse the filter parameters.
     *
     * @param  array  $query The filter parameters. (['slug,eq,laravel', 'total,gt,10'])
     * @return array         The parsed parameters for filtering.
     */
    public static function parseFilterQuery(array $query)
    {
        $parsedQuery = [];

        foreach ($query as $filter) {
            list($field, $operator, $value) = explode(',', $filter);

            if (static::isUnfiltrable($field)) {
                continue;
            }

            $operator = static::mapOperator($operator);

            $parsedQuery[] = [
                'field' => $field,
                'operator' => $operator,
                'value' => $value,
            ];
        }

        return $parsedQuery;
    }

    /**
     * Parse the sort parameters.
     *
     * @param  string $query The sort parameters. ('slug,-total')
     * @return array         The parsed parameters for sort.
     */
    public static function parseSortQuery($query)
    {
        $parsedQuery = [];

        foreach (explode(',', $query) as $field) {
            $order = 'asc';

            if ($field[0] == '-') {
                $order = 'desc';
                $field = substr($field, 1);
            }

            $parsedQuery[] = [
                'field' => $field,
                'order' => $order,
            ];
        }

        return $parsedQuery;
    }

    /**
     * Get the unfiltrable attributes.
     *
     * @return array
     */
    public static function getUnfiltrable()
    {
        return static::$unfiltrable;
    }

    /**
     * Determine if the given key is filtrable.
     *
     * @param  string $key
     * @return array
     */
    public static function isUnfiltrable($key)
    {
        return in_array($key, static::getUnfiltrable());
    }
}
