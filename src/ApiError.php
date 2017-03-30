<?php

namespace SdV\Endpoint;

use Illuminate\Http\JsonResponse;

class ApiError
{
    /**
     * The HTTP status code.
     * @var string
     */
    protected $status;

    /**
     * The ApiError title.
     * @var string
     */
    protected $title;

    /**
     * The ApiError options.
     * @var array
     */
    protected $options;

    /**
     * Instantiate a new ApiError.
     *
     * @param string $status The HTTP status code.
     * @param string $title  The error title.
     * @param array  $options The options.
     */
    public function __construct($status, $title, array $options = [])
    {
        $this->status = $status;
        $this->title = $title;
        $this->options = $options;
    }

    public static function badRequest($title, array $options = [])
    {
        return new static('400', $title, $options);
    }

    public static function unauthorized($title, array $options = [])
    {
        return new static('401', $title, $options);
    }

    public static function forbidden($title, array $options = [])
    {
        return new static('403', $title, $options);
    }

    public static function notFound($title, array $options = [])
    {
        return new static('404', $title, $options);
    }

    public static function methodNotAllowed($title, array $options = [])
    {
        return new static('405', $title, $options);
    }

    public static function unprocessableEntity($title, array $options = [])
    {
        return new static('422', $title, $options);
    }

    public static function tooManyRequests($title, array $options = [])
    {
        return new static('429', $title, $options);
    }

    public static function serverError($title, array $options = [])
    {
        return new static('500', $title, $options);
    }

    /**
     * Returns the HTTP status code.
     *
     * @return string
     */
    public function status()
    {
        return $this->status;
    }

    /**
     * Returns the error title.
     *
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Returns the options.
     *
     * @return array
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * Normalize the ApiError output.
     *
     * @return array The normalized array.
     */
    public function normalize()
    {
        return [
            'error' => array_merge([
                'status' => (string) $this->status,
                'title' => $this->title,
            ], $this->options)
        ];
    }
}
