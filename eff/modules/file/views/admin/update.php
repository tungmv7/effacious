<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model eff\modules\file\models\File */

$this->title = Yii::t('file', 'Update {modelClass}: ', [
    'modelClass' => 'File',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('file', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('file', 'Update');
?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
