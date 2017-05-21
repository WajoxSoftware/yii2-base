<div class="webinar-view">
    <div class="row">
        <div class="col m3 s12">
            <div class="webinar-left-bar">
                <?= $this->render('_left_bar', [
                    'model' => $model,
                    'viewer' => $viewer,
                ]) ?>
            </div>
        </div>
        <div class="col m9 s12">
            <div class="webinar-content">
                <?= $this->render('_player', ['model' => $model]) ?>
            </div>
        </div>
    </div>
</div>

<?= $this->render('_js', ['model' => $model]) ?>
<style type="text/css">
    .webinar-left-bar {
        background: #fff;
        padding: 1em;
    }
    .webinar-viewers-list {
        margin: 1em -1em 1em -1em;
        max-height: 200px;
        overflow: auto;
    }
    .webinar-viewers-count {
        border-radius: 3px;
        background: #eee;
        padding: 3px 10px;
    }
    .webinar-content {
        padding: 1em 0em;
    }
    .webinar-video-player {
        background: #000;
        color: #fff;
        padding: 1em;
    }
    .webinar-advert {
        background: #fff;
        padding: 1em;
        margin-top: 1em;
    }
    .webinar-message-form form {
        border: 0;
        padding: 0;
    }

    nav {
        display: none;
    }
</style>
