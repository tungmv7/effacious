<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model eff\modules\file\models\File */

$this->title = Yii::t('file', 'Add New File');
$this->params['breadcrumbs'][] = ['label' => Yii::t('file', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
