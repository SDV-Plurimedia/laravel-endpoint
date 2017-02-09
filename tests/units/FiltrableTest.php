<?php

namespace Tests;

class FiltrableTest extends AbstractTestCase
{
    /** @test */
    function filter_query_string_is_parsed()
    {
        $query = [
            'slug,eq,laravel',
            'slug,eq,eloquent',
        ];

        $model = $this->getObjectForTrait('\SdV\Endpoint\Filtrable');

        $parsedQuery = $model::parseFilterQuery($query);

        $this->assertEquals([
            [
                'field' => 'slug',
                'operator' => '=',
                'value' => 'laravel',
            ],
            [
                'field' => 'slug',
                'operator' => '=',
                'value' => 'eloquent',
            ]
        ], $parsedQuery);
    }

    /** @test */
    function sort_query_string_is_parsed()
    {
        $sortQuery = 'name,-slug';

        $model = $this->getObjectForTrait('\SdV\Endpoint\Filtrable');

        $parsedQuery = $model::parseSortQuery($sortQuery);

        $this->assertEquals([
            [
                'field' => 'name',
                'order' => 'asc',
            ],
            [
                'field' => 'slug',
                'order' => 'desc',
            ]
        ], $parsedQuery);
    }

    /** @test */
    function operator_is_equal_if_inexistant()
    {
        $model = $this->getObjectForTrait('\SdV\Endpoint\Filtrable');

        $operator = $model::mapOperator('gta');

        $this->assertEquals($operator, '=');

        $operator = $model::mapOperator('gt');

        $this->assertEquals($operator, '>');
    }
}
