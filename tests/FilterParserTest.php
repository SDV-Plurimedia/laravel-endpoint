<?php

namespace SdV\Endpoint\Tests;

use SdV\Endpoint\Filter;
use SdV\Endpoint\FilterParser;

class FilterParserTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_parser()
    {
        $parser = new FilterParser();

        $this->assertInstanceOf(FilterParser::class, $parser);
    }

    /** @test */
    function parse_request_input()
    {
        $parser = new FilterParser;

        $filters = $parser->parse([
            'slug,eq,laravel',
            'slug,eq,eloquent',
        ]);

        $this->assertEquals(new Filter('slug', '=', 'laravel'), $filters[0]);
        $this->assertEquals(new Filter('slug', '=', 'eloquent'), $filters[1]);
    }

    /** @test */
    function operator_defaults_to_equal_if_inexistant()
    {
        $parser = new FilterParser;

        $filters = $parser->parse([
            'slug,inexistant-condition,laravel',
        ]);

        $this->assertEquals(new Filter('slug', '=', 'laravel'), $filters[0]);
    }

    /** @test */
    function cant_filter_an_unfiltrable_field()
    {
        $parser = new FilterParser(['slug']);

        $filters = $parser->parse([
            'slug,eq,laravel',
            'name,eq,eloquent',
        ]);

        $this->assertEquals(new Filter('slug', '=', 'laravel'), $filters[0]);
        $this->assertEquals(1, count($filters));
    }
}
