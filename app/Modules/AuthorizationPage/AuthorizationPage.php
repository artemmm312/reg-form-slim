<?php

namespace App\Modules\AuthorizationPage;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AuthorizationPage
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		return $this->container->get('view')->render($response, 'authorization.twig', ['title' => 'Авторизация']);
	}
}
