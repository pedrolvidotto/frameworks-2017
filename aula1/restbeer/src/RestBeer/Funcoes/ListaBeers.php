<?php

namespace RestBeer\Funcoes;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ListaBeers implements MiddlewareInterface
{

    private $db;

    public function __construct($db){
    	
        $this->db = $db;
    }

      public function __invoke(Request $request, Response $response, callable $out = null)
    {
   
        $stmt = $this->db->prepare('select name from  beer');
        $stmt->execute();
    
	    $beers = $stmt->fetchAll(\PDO::FETCH_COLUMN);

	    $response->getBody()->write(implode(',',$beers));


	    return $out($request, $response); //certo
    }
}
