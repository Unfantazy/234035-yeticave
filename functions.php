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
 * @return возвращает форматированный остаток времени
*/
function time_left() {
    date_default_timezone_set('Europe/Moscow');
    $timer = strtotime('tomorrow') - strtotime('now');
    $hours = floor($timer / 3600);
    $minutes = floor(($timer % 3600) / 60);
    return sprintf('%02d', $hours) . ':' . sprintf('%02d', $minutes);
}
