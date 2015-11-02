<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model eff\modules\tree\models\Tree */

$this->title = Yii::t('file', 'Create Tree');
$this->params['breadcrumbs'][] = ['label' => Yii::t('file', 'Trees'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tree-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
