<?php

require_once 'config.php';
require_once 'init.php';
require_once 'functions.php';
require_once 'db_functions.php';
require_once 'mysql_helper.php';

$is_auth = false;
$errors = [];
$auth = [];
$check_pass = false;

if (isset($_SESSION['id'])) {
  $is_auth = true;
  $user_name = $_SESSION['name'];
  $user_avatar = $_SESSION['avatar'];
}

if ($link) {
    $sql_category = get_categories();
    $categories = get_data($link, $sql_category);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth = $_POST;
    $required = ['email', 'password'];

    foreach ($required as $field) {
        if (empty($auth[$field])) {
            $errors[$field] = 'Поле не заполнено';
        }
    }

    if (empty($errors)) {
        if (filter_var($auth['email'], FILTER_VALIDATE_EMAIL)) {
            $sql_user = check_email();
            $stmt = db_get_prepare_stmt($link, $sql_user, [$auth['email']]);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            if (!empty($rows[0])) {
                $check_pass = password_verify($auth['password'], $rows[0]['password']);
            }
            if (!$check_pass) {
                $errors['form'] = 'Пользователь не найден';
            } else {
                $_SESSION['email'] = $auth['email'];
                $_SESSION['id'] = $rows[0]['id'];
                $_SESSION['name'] = $rows[0]['name'];
                $_SESSION['avatar'] = $rows[0]['avatar'];
                header("Location: / ");
            }
        } else {
            $errors['email'] = 'Email должен быть корректным';
        }
    }
}

$content = render_template('login', $categories, $errors, $auth);
$output = render_template('layout', [
    'title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'content' => $content
]);

print($output);
