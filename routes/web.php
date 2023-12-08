<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/*$router->get('/', function () use ($router) {
    return $router->app->version();
});*/
$router->get('/', ['uses' => 'Controller@index']);
$router->get('/editor', 'Controller@editor');
$router->post('/track', 'Controller@track');
$router->get('/download', 'Controller@download');

$router->post('/upload', 'Controller@upload');
$router->post('/saveas', 'Controller@saveas');
$router->get('/files', 'Controller@files');
$router->get('/assets', 'Controller@saveas');
$router->post('/convert', 'Controller@convert');
$router->get('/history', 'Controller@history');
$router->get('/reference', 'Controller@reference');
$router->post('/rename', 'Controller@rename');
$router->post('/restore', 'Controller@restore');
$router->get('/csv', 'Controller@csv');