<?php

namespace SdV\Endpoint;

use SdV\Endpoint\Sort;
use SdV\Endpoint\Contracts\SortParser as Contract;

class SortParser implements Contract
{
    const ASC = 'asc';
    const DESC = 'desc';

    public function parse($sortInput)
    {
        if (is_null($sortInput)) {
            return [];
        }

        $parsedOrders = [];

        foreach (explode(',', $sortInput) as $field) {
            $parsedOrders[] = new Sort(
                $this->computeField($field),
                $this->computeDirection($field)
            );
        }

        return $parsedOrders;
    }

    protected function computeDirection($field)
    {
        if ($this->isDescending($field)) {
            return self::DESC;
        }

        return self::ASC;
    }

    protected function computeField($field)
    {
        if ($this->isDescending($field)) {
            return substr($field, 1);
        }

        return $field;
    }

    protected function isDescending($field)
    {
        return $field[0] == '-';
    }
}
