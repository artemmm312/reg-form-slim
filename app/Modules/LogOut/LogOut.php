<?php

namespace App\Modules\LogOut;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogOut
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$requestData = $request->getParsedBody();
		if ($requestData && $requestData['action'] === 'LogOut') {
			$this->container->get('session')->delete('user');
			$redirectUrl = SLIM_APP_BASEPATH . '/';
			$responseData = ['redirect' => $redirectUrl];
			$response->getBody()->write(json_encode($responseData, JSON_THROW_ON_ERROR));
			return $response
				->withHeader('Content-Type', 'application/json')
				->withStatus(200);
		}
		return $response;
	}
}
