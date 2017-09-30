<?php
namespace RestBeer\Funcoes;

use Zend\Stratigility\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ValidarLogin implements MiddlewareInterface
{
    private $validToken = 'cerveja';

    public function __invoke(Request $request, Response $response, callable $out = null)
    {
       $data = $request->getParsedBody();

       if($data['login']!= 'admin' || $data['senha'] != 'admin123'){
         return $response->withStatus(403);
       }
        $response->withStatus(201);
        return $out($request, $response);
    }

    private function isValid(Request $request)
    {
        $token = $request->getHeader('authorization');

        return $token[0] == $this->validToken;
    }
}
