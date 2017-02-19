<?php

namespace SdV\Endpoint\Tests;

use Mockery;
use PHPUnit_Framework_TestCase;

abstract class AbstractTestCase extends \Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        Mockery::close();

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return ['SdV\Endpoint\EndpointServiceProvider'];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }
}
