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

    <?= $this->render("_search", ['model' => $searchModel, 'pjaxUrl' => ['index']])?>
    <?= \eff\components\ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_item',
        'itemOptions' => [
            'tag' => 'li',
            'class' => 'file-details',
        ],
        'options' => [
            'tag' => 'ul',
            'class' => 'file-wrapper-thumbs'
        ],
        'emptyText' => \yii\helpers\Html::tag('div', 'No items found.', ['class' => 'centered']),
        'emptyTextOptions' => ['class' => 'empty file-empty']
    ]) ?>
</div>
