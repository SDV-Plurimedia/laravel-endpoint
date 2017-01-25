<?php

namespace Tests;

class MakeControllerCommandTest extends AbstractTestCase
{
    /** @test */
    function get_default_namespace()
    {
        $namespace = 'App\Http\Controllers\Api\V1';

        $this->assertEquals($namespace, 'App\Http\Controllers\Api\V1');
    }

    /** @test */
    function api_version_is_normalized()
    {
        $apiVersion = 'v1';

        $this->assertEquals($apiVersion, 'V1');

        $apiVersion = 'V1';

        $this->assertEquals($apiVersion, 'V1');
    }
}
