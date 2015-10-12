<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\PostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div style="margin: 0 0 15px 0;">
        <div class="form-inline pull-right">
            <div class="form-group">
                <div class="input-group input-group-sm">
                    <input type="text" class="form-control" placeholder="Keywords ...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="glyphicon glyphicon-search"></i> Search
                        </button>
                    </span>
                </div>
                <button class="btn btn-default btn-sm">
                    <i class="glyphicon glyphicon-filter"></i> Filter
                </button>
                <button class="btn btn-default btn-sm">
                    <i class="glyphicon glyphicon-cog"></i> Settings
                </button>
            </div>
            <div class="form-group">
                <div class="dropdown">
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        <i class="glyphicon glyphicon-export"></i> Export
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                        <li><a href="#">PDF</a></li>
                        <li><a href="#">HTML</a></li>
                        <li><a href="#">PDF</a></li>
                        <li><a href="#">EXCEL</a></li>
                        <li><a href="#">JSON</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
