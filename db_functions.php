<?php

function get_lots() {
  return "
  SELECT lots.name, lots.initial_price, lots.image, categories.name as category, COUNT(bets.lot_id) as betsCount, MAX(bets.amount) + lots.initial_price as betsPrice
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

function get_data($connect, $sql) {
    $result = mysqli_query($connect, $sql);
    if (!$result) {
        return '';
    }
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    return $data;
}
