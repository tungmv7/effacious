<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model eff\modules\tree\models\Tree */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tree-form">
    <?= \eff\widgets\Alert::widget() ?>
<!--    --><?php //\yii\widgets\Pjax::begin() ?>
    <?php $form = ActiveForm::begin([
        'options' => [
            'data-pjax' => ''
        ]
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= Html::activeHiddenInput($model, 'version') ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('file', 'Create') : Yii::t('file', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
<!--    --><?php //\yii\widgets\Pjax::end() ?>
</div>
