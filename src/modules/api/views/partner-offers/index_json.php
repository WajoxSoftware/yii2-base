<?php
if (sizeof($models) > 0) {
    foreach ($models as $id => $model) {
        $result[] = [
            'id' => $id,
            'text' => $model->goodTitle,
            'fee_1_level' => $model->fee_1_level,
            'fee_2_level ' => $model->fee_2_level,
            'partner_link' => $model->partner_link,
            'partner_id' => $model->partner_id,
            'good_id' => $model->good_id,
        ];
    }
} else {
    $result = ['id' => '', 'text' => ''];
}

echo json_encode(['results' => $result]);
