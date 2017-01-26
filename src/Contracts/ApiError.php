<?php

namespace Fab\Endpoint\Contracts;

interface ApiError
{
    public function format();

    public function statusCode();

    public function setStatusCode($statusCode);
}
