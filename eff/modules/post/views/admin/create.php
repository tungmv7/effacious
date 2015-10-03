<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */

$this->title = Yii::t('post', 'Create Post');
$this->params['breadcrumbs'][] = ['label' => Yii::t('post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading" style="display: none;">
        <h4>
            <?= Html::encode($this->title) ?>
            <small><?= Yii::t('module', 'Add new your awesome post.') ?></small>
        </h4>
    </div>
    <div class="module-index content panel-body">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    </div>
</div>
