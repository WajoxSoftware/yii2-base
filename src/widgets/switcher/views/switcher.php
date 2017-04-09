<?php
$name = $input->model->formName() . '[' . $input->attribute . ']';
$id = $input->options['id'];
$attribute = $input->attribute;
$checked = $input->model->$attribute;
?>
<div class="switch">
  <label>
    Off
    <input type="checkbox" value="1" id="<?= $id ?>" name="<?= $name ?>" <?= $input->disabled ? 'disabled"' : '' ?> <?= $checked ? 'checked' : '' ?>>
    <span class="lever"></span>
    On
  </label>
</div>


