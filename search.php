<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';
require_once 'init.php';
require_once 'mysql_helper.php';
require_once 'vendor/autoload.php';

$is_auth = check_auth();

if (!isset($_GET['search'])) {
    http_response_code(404);
    exit();
}

if ($link) {
    $search = htmlspecialchars($_GET['search'], ENT_QUOTES);
    $cur_page = intval($_GET['page'] ?? 1);

    $page_items = 9;
    $sql_category = get_categories();
    $categories = get_data($link, $sql_category);

    $sql = search_count_lots();
    $stmt = db_get_prepare_stmt($link, $sql, [$search]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);

    $items_count = count($lots);
    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;
    $pages = range(1, $pages_count);

    $sql_pag = search_lots();
    $stmt = db_get_prepare_stmt($link, $sql_pag, [$search, $page_items, $offset]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
}

foreach ($lots as $i => $array) {
    foreach ($array as $key => &$value) {
        if (is_string($value)) {
            $lots[$i][$key] = htmlspecialchars($value, ENT_QUOTES);
        }
    }
}

$content = render_template('search', $lots, [
    'search' => $search,
    'pages_count' => $pages_count,
    'cur_page' => $cur_page
], $pages, $categories);
$output = render_template('layout', [
    'title' => 'Результаты поиска',
    'is_auth' => $is_auth['is_auth'],
    'user_name' => $is_auth['user_name'],
    'user_avatar' => $is_auth['user_avatar'],
    'categories' => $categories,
    'content' => $content
]);

print($output);
