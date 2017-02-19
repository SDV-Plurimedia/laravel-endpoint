<?php

namespace SdV\Endpoint\Tests;

use Mockery;
use SdV\Endpoint\Tests\Fixtures\FiltrableTestModel;
use SdV\Endpoint\Filter;

class FilterTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_filter()
    {
        $filter = new Filter('field', '=', 'value');

        $this->assertInstanceOf(Filter::class, $filter);
    }

    /** @test */
    function can_get_field()
    {
        $filter = new Filter('field', '=', 'value');

        $this->assertEquals('field', $filter->field());
    }

    /** @test */
    function can_get_operator()
    {
        $filter = new Filter('field', '=', 'value');

        $this->assertEquals('=', $filter->operator());
    }

    /** @test */
    function can_get_value()
    {
        $filter = new Filter('field', '=', 'value');

        $this->assertEquals('value', $filter->value());
    }
}
