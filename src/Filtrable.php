<?php

namespace SdV\Endpoint;

trait Filtrable
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
    * Get all of the filtrable attributes on the model.
    *
    * @return array
    */
    public function getFiltrable()
    {
        return $this->filtrable;
    }

    /**
     * Perform filtering against the model's data.
     *
     * @param  string  $query The filter query.
     * @param  string  $satisfy
     * @return Builder
     */
    public static function filter($query, $satisfy = 'all')
    {
        if (is_null($query)) {
            $query = [];
        }

        return (new static)->makeBuilder()->filter($query, $satisfy);
    }

    /**
     * Perform sort against the model's data.
     *
     * @param  string  $query The sort query.
     * @return Builder
     */
    public static function sort($query)
    {
        return (new static)->makeBuilder()->sort($query);
    }

    public function makeBuilder()
    {
        if (is_null($this->builder)) {
            $this->builder = new Builder(
                $this,
                new FilterParser,
                new SortParser
            );
        }

        return $this->builder;
    }
}
