<?php
use Yii;
use yii\bootstrap\Nav;

$menus = [
    ['label' => Yii::t('module', 'Installed Modules'), 'url' => ['module/installed']],
    ['label' => Yii::t('module', 'Marketplace'), 'url' => ['module/marketplace']],
    ['label' => Yii::t('module', 'Available Updates'), 'url' => ['module/available-updates']]
];

echo Nav::widget([
    'options' => ['class' => 'nav nav-pills'],
    'items' => $menus,
]);