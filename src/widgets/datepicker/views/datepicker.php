<?php
$inputOptions = $input->options;
$inputOptions['name'] = $input->model->formName() . '[' . $input->attribute . ']';
$html = '';
foreach ($inputOptions as $key => $value) {
    $html .= ' ' . $key . '="' . $value . '"';
}
$attribute = $input->attribute;
$value = $input->model->getAttribute($attribute);
?>
<input type="date" class="datepicker" <?= $html ?>  <?= $input->disabled ? 'disabled="true"' : ''?> value="<?= $value ?>"  data-datepicker-settings="<?= rawurlencode(\json_encode($options)) ?>"/>