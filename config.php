<?php

define('DSN', 'mysql:host=localhost;dbname=dotinstall_poll_php');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'kazuhirosaji');

define('SITE_URL', 'localhost:3000');

error_reporting(E_ALL & ~E_NOTICE);

session_set_cookie_params(0, '/tohyo');

