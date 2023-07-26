<?php

namespace App\Modules\MainPage;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Container\ContainerInterface;

class MainPage
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		return $this->container->get('view')->render($response, 'main.twig', ['title' => 'Главная']);
	}
}