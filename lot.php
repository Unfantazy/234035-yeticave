<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

if (!isset($_GET['id'])) {
    http_response_code(404);
}
else {

    $link = mysqli_connect($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_database']);
    mysqli_set_charset($link, "utf8");

    if ($link) {
        $sql_lot_for_id = get_lot_for_id($_GET['id']);
        $sql_category = get_categories();
        $current_lot = get_data($link, $sql_lot_for_id);
        $categories = get_data($link, $sql_category);
    }

    if (empty($current_lot) || is_null($current_lot[0]['name'])) {
        http_response_code(404);
    }
    else {
        foreach ($current_lot as $key => &$val) {
            $val['name'] = htmlspecialchars($val['name']);
            $val['description'] = htmlspecialchars($val['description']);
            $val['image'] = htmlspecialchars($val['image']);
            $val['step_lot'] = htmlspecialchars($val['step_lot']);
            $val['category'] = htmlspecialchars($val['category']);
            $val['betsCount'] = htmlspecialchars($val['betsCount']);
            $val['betsPrice'] = htmlspecialchars($val['betsPrice']);
        }

        $sql_bets_for_id = get_bets_for_id($_GET['id']);
        $current_bets = get_data($link, $sql_bets_for_id);

        $content = render_template('lot', $current_lot[0], $current_bets);
        $output = render_template('layout', [
            'title' => 'Главная',
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'user_avatar' => $user_avatar,
            'categories' => $categories,
            'content' => $content
        ]);

        print($output);
    }
}
