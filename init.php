<?php

$link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_database']);
mysqli_set_charset($link, "utf8");
session_start();
