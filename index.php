<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';
require_once 'init.php';
require_once 'vendor/autoload.php';

$is_auth = false;

if (isset($_SESSION['id'])) {
  $is_auth = true;
  $user_name = $_SESSION['name'];
  $user_avatar = $_SESSION['avatar'];
}

if ($link) {
    $sql_lots = get_lots();
    $sql_category = get_categories();
    $lots = get_data($link, $sql_lots);
    $categories = get_data($link, $sql_category);
}

foreach ($lots as $i => $array) {
    foreach ($array as $key => &$value) {
        if (is_string($value)) {
            $lots[$i][$key] = htmlspecialchars($value, ENT_QUOTES);
        }
    }
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
