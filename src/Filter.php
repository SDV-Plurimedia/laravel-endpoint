<?php

namespace SdV\Endpoint;

class Filter
{
    protected $field;

    protected $operator;

    protected $value;

    public function __construct($field, $operator, $value)
    {
        $this->field = $field;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function field()
    {
        return $this->field;
    }

    public function value()
    {
        return $this->value;
    }

    public function operator()
    {
        return $this->operator;
    }
}
