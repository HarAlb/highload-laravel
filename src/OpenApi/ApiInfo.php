<?php
namespace Src\OpenApi;

use OpenApi\Attributes as OAT;

#[OAT\Info(version: '1.0', title: 'Highload API')]
#[OAT\Server(url: 'http://highload.test/api', description: 'Main API Server')]
class ApiInfo
{
    // Просто класс с общими атрибутами OpenAPI
}
