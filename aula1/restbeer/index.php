<?php
use Zend\Expressive\AppFactory;

$loader = require 'vendor/autoload.php';
$loader->add('RestBeer', __DIR__.'/src');

$app = AppFactory::create();

$app->get('/', function ($request, $response, $next) {
    $response->getBody()->write('Hello, world!');
    return $response;
});

$beers = [
    'brands' => ['Heineken', 'Guinness', 'Skol', 'Colorado'],
    'styles' => ['Pilsen' , 'Stout']
];

$app->get('/brands',new RestBeer\Funcoes\ListaBrands($beers));

$app->get('/styles', new RestBeer\Funcoes\ListaStyles($beers));

$app->get('/beer/{id}', new RestBeer\Funcoes\ListaBeer($beers));

$db = new PDO('sqlite:beers.db');

$app->post('/beer', new RestBeer\Funcoes\AddBeer($db));

$app->get('/beers', new RestBeer\Funcoes\ListaBeers($db)); //verificar

$app->put('/beer/{id}', new RestBeer\Funcoes\EditBeer($db));

$app->delete('/beer/{id}', new RestBeer\Funcoes\DeleteBeer($db));

$app->post('/login', new RestBeer\Funcoes\ValidarLogin($db));

$app->pipe(new RestBeer\Auth());
$app->pipeRoutingMiddleware();
// $app->pipe(new Coderockr\Middleware\FileUpload());
$app->pipeDispatchMiddleware();
$app->pipe(new RestBeer\Format\Json());
$app->pipe(new RestBeer\Format\Html());
// $app->pipe(new RestBeer\Format\Xml());
$app->run();