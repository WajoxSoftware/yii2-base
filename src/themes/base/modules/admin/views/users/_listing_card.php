<?php
echo $this->render('_listing_list', [
    'sort' => $sort,
    'dataProvider' => $dataProvider,
  ]);
