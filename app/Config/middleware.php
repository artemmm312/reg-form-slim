<?php

use Slim\Views\TwigMiddleware;
use Slim\Middleware\Session;


$app->add(TwigMiddleware::createFromContainer($app));

$app->add(new Session([
	'name' => 'user', // Имя сессии, которое будет использоваться в куках
	'autorefresh' => true, // Обновлять время жизни сессии при каждом запросе
	'lifetime' => '1 hour', // Время жизни сессии
	'secure' => true, // Устанавливать куки только для HTTPS-соединений
	'httponly' => true, // Устанавливать куки, которые недоступны через JavaScript
	'samesite' => 'Lax', // Значение SameSite для кук
]));