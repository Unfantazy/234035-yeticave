<nav class="nav">
  <ul class="nav__list container">
      <?php foreach ($data as $key => $val): ?>
          <li class="nav__item">
              <a href="all-lots.php?category=<?=$val['name']; ?>"><?=$val['name']; ?></a>
          </li>
      <?php endforeach; ?>
  </ul>
</nav>

<form class="form container <? if(!empty($extra)): ?>form--invalid<? endif ?>" action="sign-up.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
  <h2>Регистрация нового аккаунта</h2>
  <?php $class_name = isset($extra['email']) ? "form__item--invalid" : "";
  $value = isset($values['email']) ? $values['email'] : ""; ?>
  <div class="form__item <?=$class_name; ?>"> <!-- form__item--invalid -->
    <label for="email">E-mail*</label>
    <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value; ?>" >
    <span class="form__error">Введите e-mail</span>
  </div>
  <?php $class_name = isset($extra['password']) ? "form__item--invalid" : "";
  $value = isset($values['password']) ? $values['password'] : ""; ?>
  <div class="form__item <?=$class_name; ?>">
    <label for="password">Пароль*</label>
    <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?=$value; ?>" >
    <span class="form__error">Введите пароль</span>
  </div>
  <?php $class_name = isset($extra['name']) ? "form__item--invalid" : "";
  $value = isset($values['name']) ? $values['name'] : ""; ?>
  <div class="form__item <?=$class_name; ?>">
    <label for="name">Имя*</label>
    <input id="name" type="text" name="name" placeholder="Введите имя" value="<?=$value; ?>" >
    <span class="form__error">Введите имя</span>
  </div>
  <?php $class_name = isset($extra['message']) ? "form__item--invalid" : "";
  $value = isset($values['message']) ? $values['message'] : ""; ?>
  <div class="form__item <?=$class_name; ?>">
    <label for="message">Контактные данные*</label>
    <textarea id="message" name="message" placeholder="Напишите как с вами связаться" ><?=$value; ?></textarea>
    <span class="form__error">Напишите как с вами связаться</span>
  </div>
  <?php $class_name = isset($extra['user_avatar']) ? "form__item--invalid" : ""; ?>
  <div class="form__item form__item--file form__item--last <?=$class_name; ?>">
    <label>Аватар</label>
    <div class="preview">
      <button class="preview__remove" type="button">x</button>
      <div class="preview__img">
        <img src="img/avatar.jpg" width="113" height="113" alt="Ваш аватар">
      </div>
    </div>
    <div class="form__input-file">
      <input class="visually-hidden" type="file" id="photo2" name="user_avatar" value="">
      <label for="photo2">
        <span>+ Добавить</span>
      </label>
    </div>
    <span class="form__error">Загрузите картинку в формате jpg</span>
  </div>
  <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
  <button type="submit" class="button">Зарегистрироваться</button>
  <a class="text-link" href="login.php">Уже есть аккаунт</a>
</form>
