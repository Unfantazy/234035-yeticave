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
<form class="form container <? if(!empty($extra)): ?>form--invalid<? endif ?>" action="login.php" method="post"> <!-- form--invalid -->
  <h2>Вход</h2>
  <?php $class_name = isset($extra['email']) ? "form__item--invalid" : "";
  $value = isset($values['email']) ? $values['email'] : ""; ?>
  <div class="form__item <?=$class_name; ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>" >
    <span class="form__error">Введите e-mail</span>
  </div>
  <?php $class_name = isset($extra['password']) ? "form__item--invalid" : "";
  $value = isset($values['password']) ? $values['password'] : ""; ?>
  <div class="form__item form__item--last <?=$class_name; ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=$value; ?>" >
    <span class="form__error">Введите пароль</span>
  </div>
  <?php $value = isset($extra['form']) ? $extra['form'] : "Пожалуйста, исправьте ошибки в форме."; ?>
  <span class="form__error form__error--bottom"><?=$value; ?></span>
  <button type="submit" class="button">Войти</button>
</form>
