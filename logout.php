<?php

require_once 'config.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

session_destroy();
header("Location: / ");
