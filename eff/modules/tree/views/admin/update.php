<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model eff\modules\tree\models\Tree */

$this->title = Yii::t('file', 'Update {modelClass}: ', [
    'modelClass' => 'Tree',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('file', 'Trees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('file', 'Update');
?>
<div class="tree-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
