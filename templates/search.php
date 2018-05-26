<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($inf as $key => $val): ?>
            <li class="nav__item">
                <a href="all-lots.php?category=<?=$val['name']; ?>"><?=$val['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<div class="container">
    <section class="lots">
        <h2>Результаты поиска по запросу «<span><?=$extra['search']; ?></span>»</h2>
        <ul class="lots__list">
            <?php if (empty($data)): ?>
            <p>Ничего не найдено по вашему запросу</p>
            <?php else: ?>
            <?php foreach ($data as $key => $val): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$val['image']; ?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$val['category']; ?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$val['id']; ?>"><?=$val['name']; ?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=format_price($val['initial_price']); ?></span>
                        </div>
                        <div class="lot__timer timer">
                            <?=time_left(); ?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </section>
    <?php if ($extra['pages_count'] > 1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
            <?php if ($extra['cur_page'] > 1): ?>
            <a href="/search.php?search=<?=$extra['search']; ?>&page=<?=$extra['cur_page'] - 1; ?>">Назад</a>
            <?php endif; ?>
        </li>
        <?php foreach ($values as $page): ?>
        <li class="pagination-item <?php if ($page == $extra['cur_page']): ?>pagination-item-active<? endif ?>">
            <a href="/search.php?search=<?=$extra['search']; ?>&page=<?=$page; ?>"><?=$page; ?></a>
        </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
            <?php if ($extra['cur_page'] < $extra['pages_count']): ?>
            <a href="/search.php?search=<?=$extra['search']; ?>&page=<?=$extra['cur_page'] + 1; ?>">Вперед</a>
            <?php endif; ?>
        </li>
    </ul>
    <?php endif; ?>
</div>