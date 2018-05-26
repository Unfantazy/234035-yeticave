<?php

require_once 'config.php';
require_once 'init.php';

session_destroy();
header("Location: / ");
