<?php

use Interfaces\Http\Requests\Post\CreatePostRequest;
use Interfaces\Http\Handlers\Post\CreatePostHandler;
use Interfaces\Http\Handlers\Post\GetPostListHandler;
use Interfaces\Http\Requests\Post\UploadMediaRequest;
use Interfaces\Http\Handlers\Post\UploadMediaToPostHandler;

/** @var Illuminate\Routing\Router $router */
$router->post('/posts', function (CreatePostRequest $request, CreatePostHandler $handler) {
    return $handler->handle($request);
});

$router->post('/posts/{id}/media', function (int $id, UploadMediaRequest $request, UploadMediaToPostHandler $handler) {
    return $handler->handle($request, $id);
});

$router->get('/posts', function (GetPostListHandler $handler) {
    return $handler->handle(request());
});
