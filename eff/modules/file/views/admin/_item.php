<?php

use yii\helpers\Html;

if (strpos($model->type, 'image') === 0) {
    $fullUrl = Yii::$app->params['staticDomain'] . '/resize' . $model->url . '?h=150';
    $file = Html::tag('div', Html::tag('div', Html::img($fullUrl), ['class' => 'centered']), ['class' => 'item']);
    echo Html::tag('div', $file, ['class' => 'file-thumbnail']);
    echo Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok check-sign']);
} else {
    $fileName = Html::tag('span', $model->name, ['class' => 'file-name']);
    if (strpos($model->type, 'video') === 0) {
        $icon = 'glyphicon glyphicon-film';
    } else if (strpos($model->type, 'audio') === 0) {
        $icon = 'glyphicon glyphicon-music';
    } else {
        $icon = 'glyphicon glyphicon-file';
    }
    $fileExtension = Html::tag('div', Html::tag('span', '', ['class' => $icon]) . $model->extension, ['class' => 'file-extension']);
    echo Html::tag('div', Html::tag('div', Html::tag('div', $fileExtension . $fileName, ['class' => 'file']), ['class' => 'item']), ['class' => 'file-thumbnail']);
    echo Html::tag('span', '', ['class' => 'glyphicon glyphicon-ok check-sign']);
}
?>