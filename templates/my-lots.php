<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($data as $key => $val): ?>
            <li class="nav__item">
                <a href="all-lots.php?category=<?=$val['name']; ?>"><?=$val['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<section class="rates container">
    <h2>Мои ставки</h2>
    <table class="rates__list">
        <?php foreach ($extra as $key => $val): ?>
        <tr class="rates__item <?=$val['class']; ?>">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?=$val['image']; ?>" width="54" height="40" alt="Сноуборд">
                </div>
                <div>
                    <h3 class="rates__title"><a href="lot.php?id=<?=$val['lot_id']; ?>"><?=$val['name']; ?></a></h3>
                    <?php if (isset($_SESSION['id']) && $_SESSION['id'] == $val['winner_id']): ?>
                    <p><?=$val['description']; ?></p>
                    <?php endif; ?>
                </div>
            </td>
            <td class="rates__category">
                <?=$val['category']; ?>
            </td>
            <td class="rates__timer">
                <div class="timer <?=$val['timer']; ?>"><?=$val['text']; ?></div>
            </td>
            <td class="rates__price">
                <?=format_price($val['amount']); ?>
            </td>
            <td class="rates__time">
                <?=$val['date']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>
