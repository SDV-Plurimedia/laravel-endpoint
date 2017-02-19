<?php

namespace SdV\Endpoint\Tests;

use Mockery;
use SdV\Endpoint\Tests\Fixtures\FiltrableTestModel;
use SdV\Endpoint\Sort;

class SortTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_sort()
    {
        $sort = new Sort('field', 'asc');

        $this->assertInstanceOf(Sort::class, $sort);
    }

    /** @test */
    function can_get_field()
    {
        $sort = new Sort('field', 'asc');

        $this->assertEquals('field', $sort->field());
    }

    /** @test */
    function can_get_direction()
    {
        $sort = new Sort('field', 'asc');

        $this->assertEquals('asc', $sort->direction());
    }
}
