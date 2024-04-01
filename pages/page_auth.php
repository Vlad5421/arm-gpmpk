<div class="form_auth_pmpk">
  <span>АРМ ПМПК для обработки заявок поданных он-лайн</span>
  <form action="/do/login_arm.php" method="post">

    <legend>Авторизуйтесь в АРМ</legend>
    <div class="form-group">
      <label for="email">Введите логин (ваш Email):</label>
      <input type="email" name="email" class="form-control" id="email" aria-describedby="Email" placeholder="Введите email" required>
    </div>
    <div class="form-group">
      <label for="password">Введите пароль:</label>
      <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
    </div>
    <button type="submit" class="btn btn-success">Аворизоваться</button>
  </form>
</div>