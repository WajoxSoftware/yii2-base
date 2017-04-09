<?php
$name = $input->model->formName() . '[' . $input->attribute . ']';
$id = $input->options['id'];
?>
<div class="file-field input-field">
  <div class="btn">
    <span>File</span>
    <input type="file" id="<?= $id ?>" name="<?= $name ?>" <?= $input->disabled ? 'disabled="true"' : '' ?>/>
    <input type="hidden" name="<?= $name ?>"/>
  </div>
  <div class="file-path-wrapper">
    <input class="file-path validate" type="text"/>
  </div>
</div>