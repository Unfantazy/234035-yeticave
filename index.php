<?php

require_once 'functions.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';

$link = mysqli_connect("localhost", "root", "","yeticave");
mysqli_set_charset($link, "utf8");

if ($link) {
    $sql_lots = "
    SELECT lots.name, lots.initial_price, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) + lots.initial_price as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date > NOW()
    GROUP BY lots.name, lots.initial_price, lots.image, categories.name, lots.creation_date, lots.id
    ORDER BY lots.creation_date DESC;";
    $sql_category = "
    SELECT * FROM categories;
    ";
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
