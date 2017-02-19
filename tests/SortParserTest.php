<?php

namespace SdV\Endpoint\Tests;

use SdV\Endpoint\Sort;
use SdV\Endpoint\SortParser;

class SortParserTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_parser()
    {
        $parser = new SortParser;

        $this->assertInstanceOf(SortParser::class, $parser);
    }

    /** @test */
    function parse_request_input()
    {
        $parser = new SortParser;

        $sorts = $parser->parse('name,-slug');

        $this->assertEquals(new Sort('name', 'asc'), $sorts[0]);
        $this->assertEquals(new Sort('slug', 'desc'), $sorts[1]);
    }

    /** @test */
    function parse_request_if_input_is_null()
    {
        $parser = new SortParser;

        $this->assertEquals([], $parser->parse(null));
    }
}
