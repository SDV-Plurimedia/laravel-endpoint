<?php

namespace SdV\Endpoint;

class Sort
{
    protected $field;

    protected $direction;

    public function __construct($field, $direction)
    {
        $this->field = $field;
        $this->direction = $direction;
    }

    public function field()
    {
        return $this->field;
    }

    public function direction()
    {
        return $this->direction;
    }
}
