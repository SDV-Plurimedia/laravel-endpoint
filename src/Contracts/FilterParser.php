<?php

namespace SdV\Endpoint\Contracts;

interface FilterParser
{
    public function parse(array $filterInput = []);
}
