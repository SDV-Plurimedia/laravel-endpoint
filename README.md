# Laravel Endpoint

[![Latest Stable Version](https://poser.pugx.org/sdv/laravel-endpoint/v/stable)](https://packagist.org/packages/sdv/laravel-endpoint)
[![License](https://poser.pugx.org/sdv/laravel-endpoint/license)](https://packagist.org/packages/sdv/laravel-endpoint)
[![Total Downloads](https://poser.pugx.org/sdv/laravel-endpoint/downloads)](https://packagist.org/packages/sdv/laravel-endpoint)

Laravel Endpoint is a CRUD REST API package for Laravel.

## Features

- [X] REST CRUD Endpoint scaffolding
- [X] Normalized JSON Response using [laravel-fractal](https://github.com/spatie/laravel-fractal)
- [X] Simple filtering operations
- [ ] [Elasticsearch](https://www.elastic.co/products/elasticsearch) / [Algolia](https://www.algolia.com/) search
- [ ] Api Documentation ([Swagger](http://swagger.io/swagger-ui/), [API Blueprint](https://apiblueprint.org/))

## Installation

You can pull in the package via composer:

```
$ composer require sdv/laravel-endpoint
```

Register the service provider.

```
// config/app.php
'providers' => [
    ...
    SdV\Endpoint\EndpointServiceProvider::class,
]
```

Replace the render method in ```app/Exceptions/Handler.php```.

```
use SdV\Endpoint\ProvidesExceptionsHandler;

class Handler extends ExceptionHandler
{
    use ProvidesExceptionsHandler;

    ...

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

    ...
}
```

## Commands Usage

### Create a new endpoint

```
php artisan endpoint:make:all Post v1
```

This will create all this files.

- app/Post.php
- app/Repositories/PostRepository.php
- app/Transformers/PostTransformer.php
- app/Http/Controllers/Api/V1/PostController.php

### Create a new model class.

```
php artisan endpoint:make:model Post
```

This will create the file ```app/Post.php``` and insert the minimum boilerplate with filtrable trait.

### Create a new controller class.

```
php artisan endpoint:make:controller Post v1
```

This will create the file ```app/Http/Controllers/Api/V1/PostController.php``` and insert the minimum boilerplate.

###  Create a new repository class.

```
php artisan endpoint:make:repository Post
```

This will create the file ```app/Repositories/PostRepository.php``` and insert the minimum boilerplate.

### Create a new transformer class.

```
php artisan endpoint:make:transformer Post
```

This will create the file ```app/Transformers/PostTransformer.php``` and insert the minimum boilerplate.

## API Usage

### Pagination

#### Change the selected page

```
/api/v1/topics?page=2
```

#### Change the number of items per page

```
/api/v1/topics?per_page=50
```

### Filters

The ```and``` filter is applied by default.

#### And Filter

```
/api/v1/topics?filter[]=name,eq,laravel&filter[]=name,eq,eloquent&satisfy=all
```

#### Or Filter

```
/api/v1/topics?filter[]=name,eq,laravel&filter[]=name,eq,eloquent&satisfy=any
```

### Sort

```
/api/v1/topics?sort=name
```

```
/api/v1/topics?sort=-name
```

```
/api/v1/topics?sort=-slug,name
```

### Inclusions

update your transformer to add your inclusions rules, according to fractal docs (http://fractal.thephpleague.com/transformers/)

then you can include related models on your calls
```
/api/v1/topics?includes=elements,columns
```

## License

Laravel Endpoint is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
