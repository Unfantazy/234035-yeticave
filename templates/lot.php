<nav class="nav">
  <ul class="nav__list container">
    <li class="nav__item">
      <a href="all-lots.html">Доски и лыжи</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Крепления</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Ботинки</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Одежда</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Инструменты</a>
    </li>
    <li class="nav__item">
      <a href="all-lots.html">Разное</a>
    </li>
  </ul>
</nav>
<section class="lot-item container">
  <h2><?=$data['name']; ?></h2>
  <div class="lot-item__content">
    <div class="lot-item__left">
      <div class="lot-item__image">
        <img src="<?=$data['image']; ?>" width="730" height="548" alt="Сноуборд">
      </div>
      <p class="lot-item__category">Категория: <span><?=$data['category']; ?></span></p>
      <p class="lot-item__description"><?=$data['description']; ?></p>
    </div>
    <div class="lot-item__right">
      <?php if (isset($_SESSION['id']) && $_SESSION['id'] != $data['author_id']): ?>
      <div class="lot-item__state">
        <div class="lot-item__timer timer">
          <?=time_left(); ?>
        </div>
        <div class="lot-item__cost-state">
          <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?=format_price($data['betsPrice']); ?></span>
          </div>
          <div class="lot-item__min-cost">
            Мин. ставка <span><?=$data['step_lot']; ?> р</span>
          </div>
        </div>
        <form class="lot-item__form" action="cost.php" method="post">
          <p class="lot-item__form-item">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="number" name="cost" placeholder="<?=($data['betsPrice']+$data['step_lot'])?>">
          </p>
          <button type="submit" class="button">Сделать ставку</button>
        </form>
      </div>
      <?php endif; ?>
      <div class="history">
        <h3>История ставок (<span><?=$data['betsCount']; ?></span>)</h3>
        <table class="history__list">
          <?php foreach ($extra as $key => $val): ?>
          <tr class="history__item">
            <td class="history__name"><?=$val['name']; ?></td>
            <td class="history__price"><?=format_price($val['amount']); ?></td>
            <td class="history__time"><?=$val['date']; ?></td>
          </tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
  </div>
</section>
