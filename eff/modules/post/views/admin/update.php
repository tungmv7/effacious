<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = Yii::t('post', 'Update {modelClass}: ', [
    'modelClass' => 'Post',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('post', 'Update');
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
