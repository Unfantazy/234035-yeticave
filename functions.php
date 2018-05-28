<?php

require_once 'vendor/autoload.php';

/**
 *
 * Функция разделения разряда числа пробелом
 * @param $price число
 * @return возвращает отформатированное число
*/
function format_price($price) {
    $ceil_price = ceil($price);
    $edited_price = $ceil_price;

    if ($ceil_price >= 1000) {
      $edited_price = number_format($ceil_price, 0, '', ' ');
    }
    return $edited_price . ' ₽';
}

/**
 * Функция подключения шаблона и генерации HTML
 * @param $tpl файл шаблона
 * @param $data массив данных
 * @param $extra массив данных
 * @param $values массив данных
 * @param $inf массив данных
 * @return возвращает сгенерированный HTML с данными
*/
function render_template($tpl, $data, $extra = [], $values = [], $inf = []) {
    require 'config.php';
    $path = $config['tpl_path'] . $tpl . '.php';
    if (!file_exists($path)) {
      return '';
    }
    extract($data, EXTR_PREFIX_SAME, "d_");
    extract($extra, EXTR_PREFIX_SAME, "d_");
    extract($values, EXTR_PREFIX_SAME, "d_");
    extract($inf, EXTR_PREFIX_SAME, "d_");
    ob_start();
    require_once "$path";
    return ob_get_clean();
}

/**
 * Функция вычисления остатка времени
 * @param $end_time дата завершения
 * @return возвращает форматированный остаток времени
*/
function time_left($end_time) {
    date_default_timezone_set('Europe/Moscow');
    $timer = strtotime($end_time) - strtotime('now');
    if ($timer <=0 ) {
        return 0;
    }
    $days = floor($timer / 86400);
    $timer = $timer - ($days * 86400);
    $hours = floor($timer / 3600);
    $timer = $timer - ($hours * 3600);
    $minutes = floor($timer / 60);
    if ($days <= 0) {
        return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
    }
    if ($days <= 0 && $hours <= 0) {
        return sprintf('%02d', $minutes);
    }
    return sprintf('%02d', $days) . ':' . sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}
