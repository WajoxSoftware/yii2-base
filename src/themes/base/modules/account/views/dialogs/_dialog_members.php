<ul class="media-list js-members-list dialog-mmembers">
<?php
foreach ($models as $model) {
    if (!$model->isActive()) {
        continue;
    }
    echo $this->render('_dialog_member', ['model' => $model]);
}
?>
</ul>
