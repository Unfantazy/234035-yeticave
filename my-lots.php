<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';
require_once 'init.php';
require_once 'mysql_helper.php';
require_once 'vendor/autoload.php';

$is_auth = false;

if (isset($_SESSION['id'])) {
  $is_auth = true;
  $user_name = $_SESSION['name'];
  $user_avatar = $_SESSION['avatar'];
} else {
    http_response_code(403);
    exit();
}

if ($link) {
    $sql_category = get_categories();
    $categories = get_data($link, $sql_category);
    $sql = get_lots_for_user();
    $stmt = db_get_prepare_stmt($link, $sql, [$_SESSION['id']]);
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

$class_name = "";
$timer = "";

foreach ($lots as $i => $array) {
    foreach ($array as $key => &$value) {
        $text = time_left($array['completion_date']);
        if (strtotime($array['completion_date']) < strtotime('now')) {
            $class_name = "rates__item--end";
            $timer = "timer--end";
            $text = "Торги окончены";
        }

        if ($array['winner_id'] == $_SESSION['id']) {
            $class_name = "rates__item--win";
            $timer = "timer--win";
            $text = "Ставка выиграла";
        }
        $lots[$i]['class'] = $class_name;
        $lots[$i]['timer'] = $timer;
        $lots[$i]['text'] = $text;
    }
}

$content = render_template('my-lots', $categories, $lots);
$output = render_template('layout', [
    'title' => 'Мои лоты',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'content' => $content
]);

print($output);
