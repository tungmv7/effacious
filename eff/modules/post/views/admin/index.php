<?php
use yii\helpers\Html;
use eff\components\GridView;

/* @var $this yii\web\View */
/* @var $searchModel eff\modules\post\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('post', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index content">

    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
            <?= Html::a(Yii::t('post', 'Add new post'), ['create'], ['class' => 'btn bg-warning text-muted btn-xs']) ?>
        </h3>
    </div>
    <?php \yii\widgets\Pjax::begin(); ?>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],
            'name',
            'status',
            'type',
            'visibility',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>
