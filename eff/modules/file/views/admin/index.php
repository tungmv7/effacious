<?php

use yii\helpers\Html;
use eff\components\GridView;

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
            <?= Html::a(Yii::t('file', 'Add new file'), ['create'], ['class' => 'btn bg-warning text-muted btn-xs']) ?>
        </h3>
    </div>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'name',
            'base_path',
            'base_url:url',
            'file_type',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
