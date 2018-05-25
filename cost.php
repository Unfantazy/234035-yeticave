<?php

require_once 'config.php';
require_once 'init.php';
require_once 'functions.php';
require_once 'db_functions.php';
require_once 'mysql_helper.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    $cost = $_POST['cost'];
    $user_id = $_SESSION['id'];
    $lot = $_SESSION['current_lot'];
    $min_cost = $lot['betsPrice'] + $lot['step_lot'];
    if ($cost >= $min_cost) {
        $sql = post_bet();
        $stmt = db_get_prepare_stmt($link, $sql, [$cost, $user_id, $lot['id']]);
        $res = mysqli_stmt_execute($stmt);
    }
    header("Location: /lot.php?id=" . $lot['id']);
}
