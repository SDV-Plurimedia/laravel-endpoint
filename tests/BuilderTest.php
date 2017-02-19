<?php

namespace SdV\Endpoint\Tests;

use Mockery;
use SdV\Endpoint\Builder;
use SdV\Endpoint\FilterParser;
use SdV\Endpoint\SortParser;
use SdV\Endpoint\Tests\Fixtures\FiltrableTestModel;

class BuilderTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_builder()
    {
        $builder = new Builder(
            new FiltrableTestModel,
            Mockery::mock(FilterParser::class),
            Mockery::mock(SortParser::class)
        );

        $this->assertInstanceOf(Builder::class, $builder);
    }

    /** @test */
    function can_filter_a_model()
    {
        $query = ['slug,eq,laravel'];
        $filterParser = Mockery::mock(FilterParser::class);
        $filterParser->shouldReceive('parse')->once()->with($query)->andReturn([]);
        $builder = new Builder(
            new FiltrableTestModel,
            $filterParser,
            Mockery::mock(SortParser::class)
        );

        $expectedBuilder = $builder->filter($query, 'all');

        $this->assertEquals($builder, $expectedBuilder);
    }

    /** @test */
    function can_sort_a_model()
    {
        $sort = '-name,slug';
        $sortParser = Mockery::mock(SortParser::class);
        $sortParser->shouldReceive('parse')->once()->with($sort)->andReturn([]);

        $builder = new Builder(
            new FiltrableTestModel,
            Mockery::mock(FilterParser::class),
            $sortParser
        );

        $expectedBuilder = $builder->sort($sort);

        $this->assertEquals($builder, $expectedBuilder);
    }
}
