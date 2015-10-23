<?php

use yii\helpers\Html;
use eff\components\ListView;
use eff\modules\file\widgets\FileModal;

/* @var $this yii\web\View */
/* @var $searchModel eff\modules\file\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('file', 'Files');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index content">

    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
            <?= Html::a(Yii::t('file', 'Add new file'), '#', ['class' => 'btn bg-warning text-muted btn-xs',
                'data-toggle' => 'modal',
                'data-target' => '#file_index_modal'
            ]) ?>
        </h3>
    </div>

    <?php
    echo FileModal::widget([
        'id' => 'file_index_modal',
        'header' => Html::tag('h4', 'Insert new file', ['class' => 'modal-title']),
        'embedParams' => ['withLibrary' => false]
    ]);
    ?>

    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'file-details',
        ],
        'options' => [
            'tag' => 'ul',
            'class' => 'file-wrapper'
        ]
    ]) ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
