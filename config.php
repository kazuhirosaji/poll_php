<?php

define('DSN', 'mysql:host=localhost;dbname=dotinstall_poll_php');
define('DB_USER', 'dbuser');
define('DB_PASSWORD', 'kazuhirosaji');

define('SITE_URL', 'localhost/poll_php');

error_reporting(E_ALL & ~E_NOTICE);

session_set_cookie_params(0, '/poll_php');

