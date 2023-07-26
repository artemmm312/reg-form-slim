<?php

namespace App\Modules\RegistrationPage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class RegistrationPage
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		return $this->container->get('view')->render($response, 'registration.twig', ['title' => 'Регистрация']);
	}
}