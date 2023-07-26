<?php

use Lib\Settings;

$files = [
	'db' => 'db.php',
];

$container->set('settings', function () use ($files) {
	return new Settings($files);
});
