<?php

use App\Http\Response;
use App\Controller\Admin;

//ROTA LOGIN
$obRouter->get('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\LoginController::getLogin($request));
    }
]);


//ROTA LOGIN (POST)
$obRouter->post('/admin/login', [
    'middlewares' => [
        'required-admin-logout'
    ],
    function ($request) {
        return new Response(200, Admin\LoginController::setLogin($request));
    }
]);

//ROTA LOGOUT
$obRouter->get('/admin/logout', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\LoginController::setLogout($request));
    }
]);
