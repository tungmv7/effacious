<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = "#" . $model->id . " - " . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="post-view content">

    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
            <?= Html::a(Yii::t('post', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn bg-warning text-muted btn-xs']) ?>
            <?= Html::a(Html::tag('span', '',['class' => 'glyphicon glyphicon-trash']) . ' ' .Yii::t('post', 'Move to trash'), ['delete', 'id' => $model->id], [
                'class' => 'btn bg-link text-danger btn-xs',
                'data' => [
                    'confirm' => Yii::t('post', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </h3>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'creator',
            'status',
            'slug',
            'published_at',
            'featured_image',
            'type',
            'visibility',
            'password',
            'excerpt',
            'body:ntext',
            'meta_data:ntext',
            'note:ntext',
            'created_by',
            'created_at',
            'updated_by',
            'updated_at',
        ],
    ]) ?>

</div>
