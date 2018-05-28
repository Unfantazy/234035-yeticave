<?php

require_once 'vendor/autoload.php';

/**
 * Функция запроса на получение лотов
 * @return возвращает SQL-запрос
 */
function get_lots() {
    return "
    SELECT lots.id, lots.name, lots.initial_price, lots.completion_date, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date > NOW()
    GROUP BY lots.name, lots.initial_price, lots.image, categories.name, lots.creation_date, lots.id
    ORDER BY lots.creation_date DESC;
    ";
}

/**
 * Функция запроса на получение ставок пользователя
 * @return возвращает SQL-запрос
 */
function get_lots_for_user() {
    return "
    SELECT bets.user_id, bets.id, lots.name, lots.completion_date, lots.image, lots.description, categories.name as category, bets.amount, bets.lot_id, lots.winner_id, bets.date, lots.completion_date
    FROM bets
    INNER JOIN lots ON lots.id = bets.lot_id
    LEFT JOIN categories ON lots.category_id = categories.id
    WHERE user_id = ?
    ORDER BY bets.date DESC;
    ";
}

/**
 * Функция запроса на получение лотов с вышедшим временем
 * @return возвращает SQL-запрос
 */
function get_lots_wo_winner() {
    return "
    SELECT lots.id, lots.name, MAX(bets.amount) as max_bet
    FROM lots
    INNER JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date <= NOW() and lots.winner_id IS NULL
    GROUP BY lots.id, lots.name;
    ";
}

/**
 * Функция запроса на получение победителя
 * @return возвращает SQL-запрос
 */
function get_winner() {
    return "
    SELECT bets.user_id, users.name, users.email
    FROM bets
    INNER JOIN users ON bets.user_id = users.id
    WHERE bets.amount = ?;
    ";
}

/**
 * Функция запроса на добавление победителя
 * @return возвращает SQL-запрос
 */
function post_winner() {
    return "
    UPDATE lots
    SET winner_id = ?
    WHERE id = ?;
    ";
}

/**
 * Функция запроса на количество лотов по поиску
 * @return возвращает SQL-запрос
 */
function search_count_lots() {
    return "
    SELECT lots.id, lots.name, lots.description
    FROM lots
    WHERE lots.completion_date > NOW() AND MATCH(lots.name, lots.description) AGAINST(?)
    ";
}

/**
 * Функция запроса на количество лотов по категории
 * @return возвращает SQL-запрос
 */
function count_lots_for_category() {
    return "
    SELECT lots.id, lots.name, categories.name as category
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    WHERE lots.completion_date > NOW() AND categories.name = ?;
    ";
}

/**
 * Функция запроса на лотов по категории
 * @return возвращает SQL-запрос
 */
function lots_for_category() {
    return "
    SELECT lots.id, lots.name, lots.initial_price, lots.completion_date, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) + lots.initial_price as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date > NOW() AND categories.name = ?
    GROUP BY lots.name, lots.initial_price, lots.completion_date, lots.image, categories.name, lots.creation_date, lots.id
    ORDER BY lots.creation_date DESC LIMIT ? OFFSET ?;
    ";
}

/**
 * Функция запроса на лотов по поиску
 * @return возвращает SQL-запрос
 */
function search_lots() {
    return "
    SELECT lots.id, lots.name, lots.initial_price, lots.completion_date, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) + lots.initial_price as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date > NOW() AND MATCH(lots.name, lots.description) AGAINST(?)
    GROUP BY lots.name, lots.initial_price, lots.completion_date, lots.image, categories.name, lots.creation_date, lots.id
    ORDER BY lots.creation_date DESC LIMIT ? OFFSET ?;
    ";
}

/**
 * Функция запроса на получение категорий
 * @return возвращает SQL-запрос
 */
function get_categories() {
    return "
    SELECT * FROM categories;
    ";
}

/**
 * Функция запроса на получение лота по идентификатору
 * @return возвращает SQL-запрос
 */
function get_lot_for_id($lot_id) {
    return "
    SELECT lots.id, lots.name, lots.description, lots.completion_date, lots.image, lots.step_lot, lots.author_id, categories.name as category, COUNT(bets.lot_id) as betsCount, IFNULL(MAX(bets.amount), lots.initial_price) as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.id = " . $lot_id . ";
  ";
}

/**
 * Функция запроса на получение ставок по идентификатору лота
 * @return возвращает SQL-запрос
 */
function get_bets_for_id($lot_id) {
    return "
    SELECT users.name, bets.amount, bets.date
    FROM bets
    INNER JOIN lots ON lots.id = bets.lot_id
    LEFT JOIN users ON users.id = bets.user_id
    WHERE lots.id = " . $lot_id . ";
    ";
}

/**
 * Функция запроса на добавление лота
 * @return возвращает SQL-запрос
 */
function post_lot() {
    return "
    INSERT INTO lots (creation_date, name, description, image, initial_price, completion_date, step_lot, category_id, author_id, winner_id)
    VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?, NULL);
    ";
}

/**
 * Функция запроса на проверку пользователя по email
 * @return возвращает SQL-запрос
 */
function check_email() {
    return "
    SELECT users.id, users.name, users.avatar, users.password FROM users
    WHERE users.email = ?;
    ";
}

/**
 * Функция запроса на добавление пользователя
 * @return возвращает SQL-запрос
 */
function post_user() {
    return "
    INSERT INTO users (reg_date, email, name, password, avatar, contact)
    VALUES (NOW(), ?, ?, ?, ?, ?);
    ";
}

/**
 * Функция запроса на добавление ставки
 * @return возвращает SQL-запрос
 */
function post_bet() {
    return "
    INSERT INTO bets (date, amount, user_id, lot_id)
    VALUES (NOW(), ?, ?, ?);
    ";
}

/**
 * Функция отработки sql-запроса
 * @param $connect данные соединения с базой данных
 * @param $sql ранее подготовленный запрос sql
 * @return возвращает массив данных из запроса
 */
function get_data($connect, $sql) {
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        return [];
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}
