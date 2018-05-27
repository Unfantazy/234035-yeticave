<nav class="nav">
    <ul class="nav__list container">
        <?php foreach ($data as $key => $val): ?>
            <li class="nav__item">
                <a href="all-lots.php?category=<?=$val['name']; ?>"><?=$val['name']; ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
<form class="form form--add-lot container <? if(!empty($extra)): ?>form--invalid<? endif ?>" action="add.php" method="post" enctype="multipart/form-data">
    <h2>Добавление лота</h2>
    <div class="form__container-two">
        <?php $class_name = isset($extra['lot-name']) ? "form__item--invalid" : "";
        $value = isset($values['lot-name']) ? $values['lot-name'] : ""; ?>
        <div class="form__item <?=$class_name; ?>">
            <label for="lot-name">Наименование</label>
            <input id="lot-name" type="text" name="lot-name" placeholder="Введите наименование лота" value="<?=$value; ?>" >
            <span class="form__error">Введите наименование лота</span>
        </div>
        <?php $class_name = isset($extra['category']) ? "form__item--invalid" : "";
        $value = isset($values['category']) ? $values['category'] : ""; ?>
        <div class="form__item <?=$class_name; ?>">
            <label for="category">Категория</label>
            <select id="category" name="category" >
                <option></option>
                <?php foreach ($data as $key => $val):?>
                <option <? if($value == $val['name']): ?>selected<? endif ?>><?=$val['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <span class="form__error">Выберите категорию</span>
        </div>
    </div>
    <?php $class_name = isset($extra['message']) ? "form__item--invalid" : "";
    $value = isset($values['message']) ? $values['message'] : ""; ?>
    <div class="form__item form__item--wide <?=$class_name; ?>">
        <label for="message">Описание</label>
        <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$value; ?></textarea>
        <span class="form__error">Напишите описание лота</span>
    </div>
    <?php $class_upload = empty($extra['path']) ? "" : "form__item--uploaded";
    $class_name = isset($extra['photo']) ? "form__item--invalid" : "";
    $value = isset($values['path']) ? $values['path'] : ""; ?>
    <div class="form__item form__item--file <?=$class_upload; ?> <?=$class_name; ?>"> <!-- form__item--uploaded -->
        <label>Изображение</label>
        <div class="preview">
            <button class="preview__remove" type="button">x</button>
            <div class="preview__img">
                <img src="<?=$value; ?>" width="113" height="113" alt="Изображение лота">
            </div>
        </div>
        <div class="form__input-file">
            <input class="visually-hidden" type="file" id="photo2" name="lot_image" value="">
            <label for="photo2">
                <span>+ Добавить</span>
            </label>
        </div>
        <span class="form__error"><?=$extra['photo']; ?></span>
    </div>
    <div class="form__container-three">
        <?php $class_name = isset($extra['lot-rate']) ? "form__item--invalid" : "";
        $value = isset($values['lot-rate']) ? $values['lot-rate'] : ""; ?>
        <div class="form__item form__item--small <?=$class_name; ?>">
            <label for="lot-rate">Начальная цена</label>
            <input id="lot-rate" type="number" name="lot-rate" placeholder="0" value="<?=$value; ?>">
            <span class="form__error">Введите начальную цену</span>
        </div>
        <?php $class_name = isset($extra['lot-step']) ? "form__item--invalid" : "";
        $value = isset($values['lot-step']) ? $values['lot-step'] : ""; ?>
        <div class="form__item form__item--small <?=$class_name; ?>">
            <label for="lot-step">Шаг ставки</label>
            <input id="lot-step" type="number" name="lot-step" placeholder="0" value="<?=$value; ?>">
            <span class="form__error">Введите шаг ставки</span>
        </div>
        <?php $class_name = isset($extra['lot-date']) ? "form__item--invalid" : "";
        $value = isset($values['lot-date']) ? $values['lot-date'] : ""; ?>
        <div class="form__item <?=$class_name; ?>">
            <label for="lot-date">Дата окончания торгов</label>
            <input class="form__input-date" id="lot-date" type="date" name="lot-date" value="<?=$value; ?>">
            <span class="form__error">Введите дату завершения торгов</span>
        </div>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Добавить лот</button>
</form>
