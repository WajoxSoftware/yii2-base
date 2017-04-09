<?php
use wajox\yii2widgets\sortwidget\SortWidget;
use wajox\yii2widgets\filterwidget\FilterWidget;
?>
<div class="row">
    <div class="col m12">
        <?php if (isset($this->params['filter'])): ?>
            <div>
                <?= FilterWidget::widget($this->params['filter']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($this->params['sort'])): ?>
            <div>
                <?= SortWidget::widget($this->params['sort']) ?>
            </div>
        <?php endif; ?>

        <?php
        echo $this->render('@app/views/shared/_flash');
        echo $content;
        ?>
    </div>
</div>
