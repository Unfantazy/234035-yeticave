<?php

require_once 'functions.php';
require_once 'db_functions.php';
require_once 'config.php';
require_once 'init.php';
require_once 'mysql_helper.php';
require_once 'vendor/autoload.php';

if (!$link) {
    exit();
}

$sql = get_lots_wo_winner();
$lots = get_data($link, $sql);
foreach ($lots as $key => $value) {
    $sql = get_winner();
    $stmt = db_get_prepare_stmt($link, $sql, [$value['max_bet']]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $winner = mysqli_fetch_all($res, MYSQLI_ASSOC);
    $sql = post_winner();
    $stmt = db_get_prepare_stmt($link, $sql, [$winner[0]['user_id'] , $value['id']]);
    $res = mysqli_stmt_execute($stmt);
    if ($res) {
        $body = render_template('email', $lots[$key], $winner[0]);
        $transport = (new Swift_SmtpTransport($mail['host'], $mail['port']))
            ->setUsername($mail['username'])
            ->setPassword($mail['password'])
        ;
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message('Ваша ставка победила'))
            ->setFrom([$mail['username'] => $mail['name']])
            ->setTo([$winner[0]['email'] => $winner[0]['name']])
            ->setBody($body, 'text/html')
        ;
        $result = $mailer->send($message);
    }
}
