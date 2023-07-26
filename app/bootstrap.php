<?php

use Slim\Factory\AppFactory;
use DI\Container;


require BASE_DIR . 'vendor/autoload.php';

$container = new Container();

AppFactory::setContainer($container);
$app = AppFactory::create();

if (SLIM_APP_BASEPATH) {
	$app->setBasePath(SLIM_APP_BASEPATH);
}

require BASE_DIR . 'app/Config/container.php';
require BASE_DIR . 'app/Config/settings/settings.php';
require BASE_DIR . 'app/Config/middleware.php';
require BASE_DIR . 'app/Config/routes.php';

$app->run();
