<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel eff\modules\post\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('post', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-default">
    <div class="panel-heading" style="display: none;">
        <h4>
            <?= Html::encode($this->title) ?>
            <small><?= Yii::t('module', 'Manage all your awesome posts.') ?></small>
        </h4>
    </div>
    <div class="module-index content panel-body">
        <?= \yii\widgets\ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => '_item'
        ]); ?>
    </div>
</div>
