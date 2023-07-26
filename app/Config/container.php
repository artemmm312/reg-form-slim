<?php

use Slim\Views\Twig;
use SlimSession\Helper;


$container->set('view', function () {
	//return Twig::create(BASE_DIR . 'templates');
	$twig = Twig::create(BASE_DIR . 'templates');
	$twig->offsetSet('pathApp', SLIM_APP_BASEPATH);
	return $twig;
});

$container->set('db', function ($container) {
	$dbConfig = $container->get('settings')->getAlias('db');
	$dsn = "mysql:host=" . $dbConfig['host'] . ";dbname=" . $dbConfig['dbname'] . ";charset=utf8mb4";
	$db = new PDO($dsn, $dbConfig['user'], $dbConfig['password']);
	
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC,);
	
	return $db;
});

$container->set('session', function () {
	return new Helper();
});
