# Laravel Endpoint

[![Latest Stable Version](https://poser.pugx.org/fabriceclementz/laravel-endpoint/v/stable)](https://packagist.org/packages/fabriceclementz/laravel-endpoint)
[![License](https://poser.pugx.org/fabriceclementz/laravel-endpoint/license)](https://packagist.org/packages/fabriceclementz/laravel-endpoint)
[![Total Downloads](https://poser.pugx.org/fabriceclementz/laravel-endpoint/downloads)](https://packagist.org/packages/fabriceclementz/laravel-endpoint)

Laravel Endpoint is a CRUD REST API package for Laravel.

This package is currently under development.

## Features

- [ ] REST CRUD Endpoint scaffolding
- [ ] Normalized JSON Response using [laravel-fractal](https://github.com/spatie/laravel-fractal)
- [ ] [Elasticsearch](https://www.elastic.co/products/elasticsearch) / [Algolia](https://www.algolia.com/) search
- [ ] Api Documentation ([Swagger](http://swagger.io/swagger-ui/), [API Blueprint](https://apiblueprint.org/))

## Installation

You can pull in the package via composer:

```
$ composer require fabriceclementz/laravel-endpoint
```

Register the service provider.

```
// config/app.php
'providers' => [
    ...
    Fab\Endpoint\EndpointServiceProvider::class,
]
```

Replace the render method in ```app/Exceptions/Handler.php```.

```
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isRequestForApi($request)) {
            return $this->renderJson($exception, $request);
        }

        return parent::render($request, $exception);
    }
```

## License

Laravel Endpoint is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
