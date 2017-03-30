<?php

namespace SdV\Endpoint\Tests;

use SdV\Endpoint\ApiError;

class ApiErrorTest extends AbstractTestCase
{
    /** @test */
    function can_instantiate_an_api_error()
    {
        $error = new ApiError('404', 'Resource not found.');

        $this->assertInstanceOf(ApiError::class, $error);
    }

    /** @test */
    function get_status_code()
    {
        $error = new ApiError('404', 'Resource not found.');

        $this->assertEquals('404', $error->status());
    }

    /** @test */
    function get_title()
    {
        $error = new ApiError('404', 'Resource not found.');

        $this->assertEquals('Resource not found.', $error->title());
    }

    /** @test */
    function get_options()
    {
        $error = new ApiError('404', 'Resource not found.', [
            'detail' => 'Fake detail.'
        ]);

        $this->assertEquals(['detail' => 'Fake detail.'], $error->options());
    }

    /** @test */
    function normalize_the_output()
    {
        $error = new ApiError('404', 'Resource not found.');

        $this->assertEquals([
            'error' => [
                'status' => '404',
                'title' => 'Resource not found.',
            ]
        ], $error->normalize());

        $error = new ApiError('404', 'Resource not found.', [
            'detail' => 'Fake detail.'
        ]);

        $this->assertEquals([
            'error' => [
                'status' => '404',
                'title' => 'Resource not found.',
                'detail' => 'Fake detail.'
            ]
        ], $error->normalize());

        $error = ApiError::notFound('Resource not found.', [
            'detail' => 'Fake detail.'
        ]);

        $this->assertEquals([
            'error' => [
                'status' => '404',
                'title' => 'Resource not found.',
                'detail' => 'Fake detail.'
            ]
        ], $error->normalize());
    }

    /** @test */
    function can_instantiate_not_found_error()
    {
        $error = ApiError::notFound('Resource not found.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('404', $error->status());
        $this->assertEquals('Resource not found.', $error->title());
    }

    /** @test */
    function can_instantiate_unprocessable_entity_error()
    {
        $error = ApiError::unprocessableEntity('Missing parameters.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('422', $error->status());
        $this->assertEquals('Missing parameters.', $error->title());
    }

    /** @test */
    function can_instantiate_server_error()
    {
        $error = ApiError::serverError('Internal Server Error.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('500', $error->status());
        $this->assertEquals('Internal Server Error.', $error->title());
    }

    /** @test */
    function can_instantiate_bad_request_error()
    {
        $error = ApiError::badRequest('The request was unacceptable.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('400', $error->status());
        $this->assertEquals('The request was unacceptable.', $error->title());
    }

    /** @test */
    function can_instantiate_unauthorized_error()
    {
        $error = ApiError::unauthorized('No valid API key provided.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('401', $error->status());
        $this->assertEquals('No valid API key provided.', $error->title());
    }

    /** @test */
    function can_instantiate_forbidden_error()
    {
        $error = ApiError::forbidden('Access forbidden.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('403', $error->status());
        $this->assertEquals('Access forbidden.', $error->title());
    }

    /** @test */
    function can_instantiate_method_not_allowed_error()
    {
        $error = ApiError::methodNotAllowed('POST not allowed.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('405', $error->status());
        $this->assertEquals('POST not allowed.', $error->title());
    }

    /** @test */
    function can_instantiate_too_many_request_error()
    {
        $error = ApiError::tooManyRequests('Too many requests hit the API.');

        $this->assertInstanceOf(ApiError::class, $error);
        $this->assertEquals('429', $error->status());
        $this->assertEquals('Too many requests hit the API.', $error->title());
    }
}
