<?php

use App\Http\Response;
use App\Controller\Admin;

//ROTA DA LISTAGEM DE DEPOIMENTOS
$obRouter->get('/admin/testimonies', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\TestimoniesController::getTestimonies($request));
    }
]);

//ROTA DE CADASTRO DE DEPOIMENTOS
$obRouter->get('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\TestimoniesController::getNewTestimonies($request));
    }
]);

//ROTA DE CADASTRO DE DEPOIMENTOS
$obRouter->post('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\TestimoniesController::setNewTestimonies($request));
    }
]);

//ROTA DE EDIÇÃO DE DEPOIMENTOS
$obRouter->get('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\TestimoniesController::getEditTestimonies($request, $id));
    }
]);


//ROTA DE EDIÇÃO DE DEPOIMENTOS
$obRouter->post('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\TestimoniesController::setEditTestimonies($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE DEPOIMENTOS
$obRouter->get('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\TestimoniesController::getDeleteTestimonies($request, $id));
    }
]);

//ROTA DE EXCLUSÃO DE DEPOIMENTOS
$obRouter->post('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\TestimoniesController::setDeleteTestimonies($request, $id));
    }
]);
