<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model eff\modules\tree\models\Tree */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('file', 'Trees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tree-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('file', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('file', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('file', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'tree',
            'lft',
            'rgt',
            'depth',
            'name',
            'icon',
            'url:url',
            'title',
            'description',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
            'version',
            'is_deleted',
            'deleted_at',
        ],
    ]) ?>

</div>
