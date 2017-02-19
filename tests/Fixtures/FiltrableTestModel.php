<?php

namespace SdV\Endpoint\Tests\Fixtures;

use SdV\Endpoint\Filtrable;

class FiltrableTestModel extends TestModel
{
    use Filtrable;

    protected $filtrable = [];
}
