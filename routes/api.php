<?php

use Interfaces\Http\Requests\Post\CreatePostRequest;
use Interfaces\Http\Handlers\Post\CreatePostHandler;
use Interfaces\Http\Handlers\Post\GetPostListHandler;

/** @var Illuminate\Routing\Router $router */
$router->post('/posts', function (CreatePostRequest $request, CreatePostHandler $handler) {
    return $handler->handle($request);
});

$router->get('/posts', function (GetPostListHandler $handler) {
    return $handler->handle(request());
});
