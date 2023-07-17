<?php

use App\Controller\Api;
use App\Http\Response;

#ROTA HOME
$obRouter->get('/api/v1/testimonies', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function ($request) {
        return new Response(200, Api\TestimoniesController::getTestimonies($request), 'application/json');
    }
]);

#ROTA RETORNA UM DEPOIMENTO ESPECIFICO
$obRouter->get('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'cache'
    ],
    function ($request, $id) {
        return new Response(200, Api\TestimoniesController::getTestimony($request, $id), 'application/json');
    }
]);

#ROTA DE CADASTRO DE DEPOIMENTO
$obRouter->post('/api/v1/testimonies', [
    'middlewares' => [
        'api',
        'user-auth'
    ],
    function ($request) {
        return new Response(201, Api\TestimoniesController::setNewTestimony($request), 'application/json');
    }
]);

#ROTA DE ATUALIZAÇÃO DE DEPOIMENTO
$obRouter->put('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'user-auth'
    ],
    function ($request, $id) {
        return new Response(200, Api\TestimoniesController::setEditTestimony($request, $id), 'application/json');
    }
]);

#ROTA DE EXCLUSÃO DE DEPOIMENTO
$obRouter->delete('/api/v1/testimonies/{id}', [
    'middlewares' => [
        'api',
        'user-auth'
    ],
    function ($request, $id) {
        return new Response(200, Api\TestimoniesController::setDeleteTestimony($request, $id), 'application/json');
    }
]);
