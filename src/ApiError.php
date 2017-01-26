<?php

namespace Fab\Endpoint;

use Fab\Endpoint\Contracts\ApiError as ApiErrorContract;

class ApiError implements ApiErrorContract
{
    /**
     * The error message.
     * @var string
     */
    protected $message;

    protected $data;

    /**
     * The error HTTP status code
     * @var integer
     */
    protected $statusCode = 500;

    /**
     * Instantiate a new api error.
     * @param void
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the formatted error.
     *
     * @return array
     */
    public function format()
    {
        $response = [
            'error' => [
                'message' => $this->message,
            ]
        ];

        if (!empty($this->data)) {
            $response['error']['errors'] = $this->data;
        }

        return $response;
    }

    /**
     * Get the status code.
     *
     * @return integer
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the status code.
     *
     * @param integer
     * @return ApiError The api error instance.
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Set the data.
     *
     * @param array
     * @return ApiError The api error instance.
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }
}
