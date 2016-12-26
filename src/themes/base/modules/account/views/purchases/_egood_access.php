<?php
    if ($model->isText) {
        $tpl = '_access_text';
    } elseif ($model->isImage) {
        $tpl = '_access_image';
    } elseif ($model->isAudio) {
        $tpl = '_access_audio';
    } elseif ($model->isVideo) {
        $tpl = '_access_video';
    } elseif ($model->isLink) {
        $tpl = '_access_link';
    } elseif ($model->isArchive) {
        $tpl = '_access_archive';
    }

    echo $this->render($tpl, ['model' => $model]);
