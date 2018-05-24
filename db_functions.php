<?php

function get_lots() {
    return "
    SELECT lots.id, lots.name, lots.initial_price, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) + lots.initial_price as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.completion_date > NOW()
    GROUP BY lots.name, lots.initial_price, lots.image, categories.name, lots.creation_date, lots.id
    ORDER BY lots.creation_date DESC;
    ";
}

function get_categories() {
    return "
    SELECT * FROM categories;
    ";
}

function get_lot_for_id($lot_id) {
    return "
    SELECT lots.name, lots.description, lots.image, lots.step_lot, categories.name as category, COUNT(bets.lot_id) as betsCount, IFNULL(MAX(bets.amount), 0) + lots.initial_price as betsPrice
    FROM lots
    INNER JOIN categories ON lots.category_id = categories.id
    LEFT JOIN bets ON lots.id = bets.lot_id
    WHERE lots.id = " . $lot_id . ";
  ";
}

function get_bets_for_id($lot_id) {
    return "
    SELECT users.name, bets.amount, bets.date
    FROM bets
    INNER JOIN lots ON lots.id = bets.lot_id
    LEFT JOIN users ON users.id = bets.user_id
    WHERE lots.id = " . $lot_id . ";
    ";
}

function post_lot() {
    return "
    INSERT INTO lots (creation_date, name, description, image, initial_price, completion_date, step_lot, category_id, author_id, winner_id)
    VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, 1, NULL);
    ";
}

function check_email() {
    return "
    SELECT users.id, users.name, users.avatar, users.password FROM users
    WHERE users.email = ?;
    ";
}

function post_user() {
    return "
    INSERT INTO users (reg_date, email, name, password, avatar, contact)
    VALUES (NOW(), ?, ?, ?, ?, ?);
    ";
}

function get_data($connect, $sql) {
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        return [];
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}
