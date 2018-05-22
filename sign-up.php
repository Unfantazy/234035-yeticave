<?php

require_once 'config.php';
require_once 'init.php';
require_once 'functions.php';
require_once 'db_functions.php';
require_once 'mysql_helper.php';

$is_auth = (bool) rand(0, 1);

$user_name = 'Константин';
$user_avatar = 'img/user.jpg';
$errors = [];
$new_user = [];

if ($link) {
    $sql_category = get_categories();
    $categories = get_data($link, $sql_category);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_user = $_POST;
    $required = ['email', 'password', 'name', 'message'];

    foreach ($required as $field) {
      if (empty($new_user[$field])) {
        $errors[$field] = 'Поле не заполнено';
      }
      else {
        if ($field == 'email') {
          if (!filter_var($new_user[$field], FILTER_VALIDATE_EMAIL)) {
            $errors[$field] = 'Email должен быть корректным';
          } else {
            $sql_user = check_email();
            $stmt = db_get_prepare_stmt($link, $sql_user, [$new_user[$field]]);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);
            $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
            if (!empty($rows[0])) {
              $errors[$field] = 'Такой пользователь уже зарегистрирован';
            }
          }
        }
      }
    }

    if (empty($errors)) {

      if (isset($_FILES['user_avatar'])) {
        $file_name = uniqid() . '.jpg';
        $new_user['avatar'] = 'img/' . $file_name;
        move_uploaded_file($_FILES['user_avatar']['tmp_name'], $new_user['avatar']);
      } else {
        $new_user['avatar'] = '';
      }

      $new_user['hash'] = password_hash($new_user['password'], PASSWORD_DEFAULT);

      $sql = post_user();
      $stmt = db_get_prepare_stmt($link, $sql, [$new_user['email'], $new_user['name'], $new_user['hash'], $new_user['avatar'], $new_user['message']]);
      $res = mysqli_stmt_execute($stmt);

      if ($res) {
        header("Location: / ");
      }
    }
  }

$content = render_template('sign-up', $categories, $errors, $new_user);
$output = render_template('layout', [
    'title' => 'Главная',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'categories' => $categories,
    'content' => $content
]);

print($output);