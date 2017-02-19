<?php

namespace SdV\Endpoint\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    public $id = 1;

    public function getKey()
    {
        return $this->id;
    }
}
