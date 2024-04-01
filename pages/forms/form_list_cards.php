<div class="list_head_div">
  <div class="list_head">Заявки на ПМПК: количество - <?= $count_cards ?></div>
</div>

<!-- Начало формы поиска -->
<div class="list_block" id="filter">
  <form action="arm.php" method="post">
    <legend>Условия поиска:</legend>
    <span class="list_filter_label">Причина записи на ПМПК:</span>
    <div class="form-check-inline">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="filter_prich" value="all">Все
      </label>
    </div>
    <div class="form-check-inline">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="filter_prich" value="gia">ГИА
      </label>
    </div>
    <div class="form-check-inline">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="filter_prich" value="mse">МСЭ
      </label>
    </div>
    <br>
    <br><!-- Поиск по фамилии  -->
    <div class="form-group">
      <label for="family"><span class="list_filter_label">Фамилия ребенка:</span></label><br>
      <input type="text" class="form-control  w-50" placeholder="Введите полностью или часть фамилии" name="filter_family">
    </div>
    <!-- КНОПКА -->
    <button class="button_form" style="margin-left: 12px;" type="submit">Найти</button>
  </form>
</div>
<!-- Конец формы поиска -->

<div class="list_block">
  <?php if (!empty($messages)) : ?>
    <?php foreach ($messages as $message) : ?>
      <?php $ssilka = 'arm.php?form=view_card&id=' . $message['id'] ?>
      <div class="message">
        <div>Подано: <?= nl2br(htmlspecialchars(date("d.m.Y H:m", strtotime($message['date'])))) ?></div>
        <div>Номер заявки: <?= nl2br(htmlspecialchars($message['id'])) ?></div>
        <div>ФИО ребенка: <?= nl2br(htmlspecialchars($message['fioreb'])) ?></div>
        <div>Дата рождения: <?= nl2br(htmlspecialchars(date("d.m.Y", strtotime($message['dateroj'])))) ?></div>
        <div>Орган направивший на ПМПК: <?= nl2br(htmlspecialchars($message['organnapr'])) ?></div>
        <div>Причина направления на ПМПК: <?= nl2br(htmlspecialchars($message['prich'])) ?></div>
        <div>Образовательная организация: <?= nl2br(htmlspecialchars($message['school'])) ?></div>
        <div>Класс/группа: <?= nl2br(htmlspecialchars($message['class'])) ?></div>
        <div>Дата прохождения прошлого ПМПК: <?= nl2br(htmlspecialchars(date("d.m.Y", strtotime($message['datepredpmpk'])))) ?></div>
        <div>Наименование предыдущего ПМПК: <?= nl2br(htmlspecialchars($message['namepredpmpk'])) ?></div>
        <div>Загруженные документы: <a href="<?= $ssilka ?>" style=" font-weight: bold;">Просмотреть</a></div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>