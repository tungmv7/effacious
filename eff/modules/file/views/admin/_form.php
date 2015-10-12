<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model eff\modules\file\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="file-form">

    <?php
    echo \eff\widgets\dropzone\DropZone::widget(
        [
            'name' => 'file', // input name or 'model' and 'attribute'
            'url' => \yii\helpers\Url::toRoute(['upload']), // upload url
            'storedFiles' => [], // stores files
            'eventHandlers' => [], // dropzone event handlers
            'sortable' => false, // sortable flag
            'sortableOptions' => [], // sortable options
            'htmlOptions' => [], // container html options
            'options' => [], // dropzone js options
        ]
    )
    ?>
</div>
