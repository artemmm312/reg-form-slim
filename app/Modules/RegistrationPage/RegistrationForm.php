<?php

namespace App\Modules\RegistrationPage;

use JsonException;
use PDO;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


class RegistrationForm
{
	private ContainerInterface $container;
	
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}
	
	/**
	 * @throws ContainerExceptionInterface
	 * @throws NotFoundExceptionInterface
	 * @throws JsonException
	 */
	public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
	{
		$requestData = $request->getParsedBody();
		$username = $requestData['username'];
		$password = $requestData['password'];
		
		if (empty($username) || empty($password)) {
			$responseData = ['error' => 'Логин/пароль не определены'];
			$response->getBody()->write(json_encode($responseData, JSON_THROW_ON_ERROR));
			return $response
				->withHeader('Content-Type', 'application/json')
				->withStatus(400);
		}
		
		try {
			$db = $this->container->get('db');
			$existingUser = $this->getUserByUsername($db, $username);
			
			if ($existingUser) {
				$responseData = ['error' => 'Логин уже зарегистрирован'];
				$response->getBody()->write(json_encode($responseData, JSON_THROW_ON_ERROR));
				return $response
					->withHeader('Content-Type', 'application/json')
					->withStatus(409);
			}
			
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$this->insertUser($db, $username, $hashedPassword);
			
			$redirectUrl = SLIM_APP_BASEPATH . '/authorization';
			$responseData = ['message' => 'Регистрация успешна', 'redirect' => $redirectUrl];
			$response->getBody()->write(json_encode($responseData, JSON_THROW_ON_ERROR));
			return $response
				->withHeader('Content-Type', 'application/json')
				->withStatus(200);
		} catch (\PDOException $e) {
			$responseData = ['error' => 'Ошибка при регистрации'];
			$response->getBody()->write(json_encode($responseData, JSON_THROW_ON_ERROR));
			return $response
				->withHeader('Content-Type', 'application/json')
				->withStatus(500);
		}
	}
	
	private function getUserByUsername(PDO $db, string $username): ?array
	{
		$stmt = $db->prepare("SELECT * FROM users WHERE login = :username");
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		$user = $stmt->fetch(PDO::FETCH_ASSOC);
		return $user ?: null;
	}
	
	private function insertUser(PDO $db, string $username, string $hashedPassword): void
	{
		$stmt = $db->prepare("INSERT INTO users (login, password) VALUES (:username, :password)");
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $hashedPassword);
		$stmt->execute();
	}
}
