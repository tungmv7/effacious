<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = Yii::t('post', 'Update Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('post', 'Update');
?>
<div class="post-index content">

    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
        </h3>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
