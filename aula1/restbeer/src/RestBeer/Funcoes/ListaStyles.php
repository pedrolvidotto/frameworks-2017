<?php

namespace RestBeer\Funcoes;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListaStyles implements MiddlewareInterface
{

    private $db;

    public function __construct($db){
        $this->db = $db;
    }

  
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
    
     $response->getBody()->write(implode(',', $this->db['styles']));
     return $out($request, $response); //certo
    }
}
