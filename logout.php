<?php

require_once 'config.php';
require_once 'init.php';

unset($_SESSION['id']);
header("Location: / ");
