<?php

function format_price($price) {
    $ceil_price = ceil($price);
    $edited_price = $ceil_price;

    if ($ceil_price >= 1000) {
      $edited_price = number_format($ceil_price, 0, '', ' ');
    }
    return $edited_price . ' ₽';
}

function render_template($tpl, $data, $extra = []) {
    require 'config.php';
    $path = $config['tpl_path'] . $tpl . '.php';
    if (!file_exists($path)) {
      return '';
    }
    extract($data, EXTR_PREFIX_SAME, "d_");
    extract($extra, EXTR_PREFIX_SAME, "d_");
    ob_start();
    require_once "$path";
    return ob_get_clean();
}

function time_left() {
    date_default_timezone_set('Europe/Moscow');
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / 3600);
    $minutes = floor(($timer % 3600) / 60);
    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}
