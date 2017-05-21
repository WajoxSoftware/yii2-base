<div>
    <h3><?= $model->title ?></h3>
    <ul class="collection" style="margin-left: -1em; margin-right: -1em;">
        <li class="collection-item avatar" style="background: #efe;">
          <i class="material-icons circle">person_pin</i>
          <span class="title"><?= $viewer->name ?></span>
          <p><?= $viewer->email ?></p>
        </li>
    </ul>

    <span id="webinar-viewers-count" class="webinar-viewers-count">0</span> участинов в эфире
</div>
<div class="viewers hide-on-small-only" id="webinar-viewers">
    <ul class="collection webinar-viewers-list"></ul>
</div>
<div class="webinar-message message">
    <?= $this->render('_message_form', ['model' => $model]) ?>
</div>
