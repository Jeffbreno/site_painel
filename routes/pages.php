<?php

use App\Http\Response;
use App\Controller\Pages;

//ROTA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Pages\HomeController::getHome());
    }
]);

//ROTA SOBRE
$obRouter->get('/sobre', [
    'middlewares' => [
        'cache'
    ],
    function () {
        return new Response(200, Pages\AboutController::getAbout());
    }
]);

//ROTA DEPOIMENTOS
$obRouter->get('/depoimentos', [
    'middlewares' => [
        'cache'
    ],
    function ($request) {
        return new Response(200, Pages\TestimonyController::getTestimonies($request));
    }
]);

//ROTA DEPOIMENTOS (INSERT)
$obRouter->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\TestimonyController::insertTestimony($request));
    }
]);
