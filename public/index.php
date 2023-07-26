<?php

define('BASE_DIR', str_replace(DIRECTORY_SEPARATOR . 'public', '',dirname(realpath(__FILE__)) . DIRECTORY_SEPARATOR));
define('SLIM_APP_BASEPATH', '/' . basename(BASE_DIR));

require BASE_DIR . 'app/bootstrap.php';