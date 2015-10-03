<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ModuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('module', 'Modules');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h4>
            <?= Html::encode($this->title) ?>
            <small><?= Yii::t('module', 'Modules extend the functionality of eff. Here you can install and manage modules from the eff Marketplace') ?></small>
        </h4>
    </div>
    <div class="module-index content panel-body">
        <?= $this->render('_nav') ?>
        <hr />
        <div class="medias">
            <?php
            \yii\widgets\Pjax::begin(['id' => 'pjax-module']);
            $moduleCount = 0;
            foreach($modules as $module) {
                echo Html::beginTag('div', ['class' => 'media']);
                echo Html::beginTag('div', ['class' => 'media-left']);
                echo Html::img($module->getIcon(), ['class' => 'media-object img-rounded']);
                echo Html::endTag('div');
                echo Html::beginTag('div', ['class' => 'media-body']);
                echo Html::tag('h5', $module->isActivated() ? $module->getName() . Html::tag('span', Yii::t('module', 'Activated'), ['class' => 'label label-info']) : $module->getName());
                echo Html::tag('p', $module->getDescription(), ['class' => 'small']);
                echo Html::beginTag('p', ['class' => 'small']);
                echo Yii::t('module', 'Version') . ' '. $module->getVersion();
                if ($module->isActivated()) {
                    echo ' - ' . Html::a(Yii::t('module', 'Disable'), '#', [
                            'data-reload' => '#pjax-module',
                            'data-url' => Url::toRoute(['change-status']),
                            'data-params' => \yii\helpers\Json::encode(['id' => $module->id, 'status' => 'active']),
                            'data-toggle' => 'modal',
                            'data-target' => '.eff-modal',
                        ]);
                } else {
                    echo ' - ' . Html::a(Yii::t('module', 'Enable'), '#', [
                            'data-reload' => '#pjax-module',
                            'data-url' => Url::toRoute(['change-status']),
                            'data-params' => \yii\helpers\Json::encode(['id' => $module->id, 'status' => 'inactive']),
                            'data-toggle' => 'modal',
                            'data-target' => '.eff-modal'
                        ]);
                }
                echo ' - ' . Html::a(Yii::t('module', 'Configuration'), Url::toRoute('/module/config'), ['data-id' => $module->id]);
                echo ' - ' . Html::a(Yii::t('module', 'Uninstall'), Url::toRoute('/module/uninstall'), ['data-id' => $module->id]);
                echo ' - ' . Html::a(Yii::t('module', 'Help'), Url::toRoute('/module/help'), ['data-id' => $module->id]);
                echo Html::endTag('p');
                echo Html::endTag('div');
                echo Html::endTag('div');
                if (++$moduleCount !== count($modules)) {
                    echo Html::tag('hr');
                }
            }
            \yii\widgets\Pjax::end();
            ?>
        </div>
    </div>
</div>