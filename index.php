<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';
require_once 'init.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

if ($link) {
    $sql_lots = get_lots();
    $sql_category = get_categories();
    $lots = get_data($link, $sql_lots);
    $categories = get_data($link, $sql_category);
}

foreach ($lots as $key => &$val) {
    $val['name'] = htmlspecialchars($val['name']);
    $val['category'] = htmlspecialchars($val['category']);
    $val['price'] = htmlspecialchars($val['price']);
    $val['url'] = htmlspecialchars($val['url']);
}

$content = render_template('index', $lots);
$output = render_template('layout', [
    'title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'content' => $content
]);

print($output);
