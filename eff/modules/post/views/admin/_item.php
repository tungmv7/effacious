<?php
$data = $model;

use yii\helpers\Html;
echo Html::beginTag('div', ['class' => 'media']);
echo Html::beginTag('div', ['class' => 'media-left']);
//echo Html::img($module->getIcon(), ['class' => 'media-object img-rounded']);
echo Html::endTag('div');
echo Html::beginTag('div', ['class' => 'media-body']);
echo Html::tag('h5', $data['name']);
echo Html::tag('p', $data['excerpt'], ['class' => 'small']);
echo Html::beginTag('p', ['class' => 'small']);
echo Yii::t('module', 'date');
echo Html::endTag('p');
echo Html::endTag('div');
echo Html::endTag('div');
echo Html::tag('hr');
