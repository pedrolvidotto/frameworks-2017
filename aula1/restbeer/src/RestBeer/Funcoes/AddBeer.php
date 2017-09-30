<?php

namespace RestBeer\Funcoes;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class AddBeer implements MiddlewareInterface
{

    private $db;

    public function __construct($db){
    	 $db->exec(
        "create table if not exists 
         beer (id INTEGER PRIMARY KEY AUTOINCREMENT, name text not null, style text not null)"
         ); 
        $this->db = $db;
    }

  
    public function __invoke(Request $request, Response $response, callable $out = null)
    {
   
	    $data = $request->getParsedBody();
	    //@TODO: clean form data before insert into the database ;)
	    $stmt = $this->db->prepare('insert into beer (name, style) values (:name, :style)');
	    $stmt->bindParam(':name',$data['name']);
	    $stmt->bindParam(':style', $data['style']);
	    $stmt->execute();
	    $data['id'] = $this->db->lastInsertId();
	    if ($data['id'] == 0) {
	        return $response->withStatus(500, "Erro salvando cerveja");
	    }
	    $response->getBody()->write($data['id']);

	   // return $response->withStatus(201);
	   //  $response->getBody()->write(implode(',', $this->db['styles']));
	     return $out($request, $response); //certo
    }
}
