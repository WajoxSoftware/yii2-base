<?php
$name = $input->model->formName() . '[' . $input->attribute . ']';
$id = $input->options['id'];
$attribute = $input->attribute;
$checked = $input->model->$attribute;
?>
<div class="switch">
  <input type="hidden" value="0" name="<?= $name ?>"/>
  <label>
    Off
    <input type="checkbox" value="1" id="<?= $id ?>" name="<?= $name ?>" <?= $input->disabled ? 'disabled"' : '' ?> <?= $checked ? 'checked' : '' ?>>
    <span class="lever"></span>
    On
  </label>
</div>


