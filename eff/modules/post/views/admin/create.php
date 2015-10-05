<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = Yii::t('post', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-content">
    <div class="content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
