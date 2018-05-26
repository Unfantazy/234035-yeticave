<?php

require_once 'config.php';
require_once 'init.php';
require_once 'functions.php';
require_once 'db_functions.php';

$is_auth = false;

if (isset($_SESSION['id'])) {
  $is_auth = true;
  $user_name = $_SESSION['name'];
  $user_avatar = $_SESSION['avatar'];
}

if (!isset($_GET['id'])) {
    http_response_code(404);
}
else {
    if ($link) {
        $id = intval($_GET['id']);
        $sql_lot_for_id = get_lot_for_id($id);
        $sql_category = get_categories();
        $current_lot = get_data($link, $sql_lot_for_id);
        $categories = get_data($link, $sql_category);
    }

    if (is_null($current_lot[0]['name'])) {
        http_response_code(404);
    }
    else {
        foreach ($current_lot as $key => &$val) {
            $val['name'] = htmlspecialchars($val['name']);
            $val['description'] = htmlspecialchars($val['description']);
            $val['image'] = htmlspecialchars($val['image']);
            $val['step_lot'] = htmlspecialchars($val['step_lot']);
            $val['category'] = htmlspecialchars($val['category']);
            $val['author_id'] = htmlspecialchars($val['author_id']);
            $val['betsCount'] = htmlspecialchars($val['betsCount']);
            $val['betsPrice'] = htmlspecialchars($val['betsPrice']);
        }

        $sql_bets_for_id = get_bets_for_id($id);
        $current_bets = get_data($link, $sql_bets_for_id);

        $content = render_template('lot', $current_lot[0], $current_bets, $categories);
        $output = render_template('layout', [
            'title' => 'Просмотр лота',
            'is_auth' => $is_auth,
            'user_name' => $user_name,
            'user_avatar' => $user_avatar,
            'categories' => $categories,
            'content' => $content
        ]);
        $_SESSION['current_lot'] = $current_lot[0];
        print($output);
        unset($_SESSION['cost']);
    }
}
