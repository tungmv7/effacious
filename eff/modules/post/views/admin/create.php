<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = Yii::t('post', 'Add New Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-create content">
    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
        </h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
