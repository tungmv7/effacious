<?php
use yii\helpers\Html;
use \eff\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form row">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-8">

        <?php

        // post name
        echo $form->beginField($model, 'name');
        echo Html::activeInput('text', $model, 'name', ['class' => 'form-control', 'maxlength' => true, 'placeholder' => Yii::t('post', 'Title') . ' ...']);
        $postLink = Html::a('http://f.dev/post/2015/10/02/this-is-a-post-1.html', 'http://f.dev/post/2015/10/02/this-is-a-post-1.html', ['class' => 'slug']);
        $changeUrlLink = Html::a(Yii::t('post', 'Change'), '');
        $currentStatus = Html::label(Html::tag('small', 'Current status: <strong>new draft</strong>'), null, ['class' => 'pull-right text-normal']);
        echo Html::tag('div', Html::tag('small', $postLink . ' - ' . $changeUrlLink) . $currentStatus, ['class' => 'help-block']);
        echo $form->endField();

        // post body - content
        echo $form->beginField($model, 'body');
        echo \eff\widgets\redactor\Redactor::widget([
            'model' => $model,
            'attribute' => 'body',
            'clientOptions' => [
                'minHeight' => '400px',
                'maxHeight' => '600px',
                'placeholder' => Yii::t('post', 'Enter your awesome content ...'),
            ]
        ]);
        echo Html::error($model, 'body', ['class' => 'help-block']);
        echo $form->endField();
        ?>

    </div>
    <div class="col-md-4">
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <span class="save-buttons">
                    <?= Html::submitButton(Yii::t('post', 'Publish Immeditaly'), ['class' => 'btn btn-success btn-submit']) ?>
                    <?= Html::a(Yii::t('post', 'Save as Draft'), '#', ['class' => 'btn']) ?>
                </span>
                <a data-toggle="collapse" href="#post-published-status" class="collapsed published-status">
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-published-status" class="collapse">
                <div class="panel-body">
                    <?= Html::radioList('status', $model::SAVE_OPTION_PUBLISH_IMMEDIATELY, $model::getSaveOptions(), ['class' => 'radio radio-list radio-save-status']) ?>
                    <script>
                        $(function(){
                            $(".radio-save-status").on('change', function(e) {
                                var text = e.target.nextSibling.nodeValue.trim();
                                var value = e.target.value;
                                if (text != 'undefined' && value != 'undefained') {
                                    $('.btn-submit').html(e.target.nextSibling.nodeValue.trim());
                                    if (value == 'publish_immediately') {
                                        $('.btn-submit').attr('class', 'btn btn-submit btn-success')
                                    } else if (value == 'publish_scheduled') {
                                        $('.btn-submit').attr('class', 'btn btn-submit btn-info')
                                    } else if (value == 'pending_review') {
                                        $('.btn-submit').attr('class', 'btn btn-submit btn-warning')
                                    }
                                }
                            })
                        })
                    </script>
                </div>
            </div>
        </div>
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-featured-image" class="header-text">
                    Featured Image
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-featured-image" class="collapse in">
                <div class="panel-body">
                    <div class="featured-image-select">
                        <a><i class="glyphicon glyphicon-picture"></i></a>
                        <button class="btn btn-primary btn-xs">Choose featured image</button>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-categories" class="header-text">
                    Categories and Tags
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-categories" class="collapse in">
                <div class="panel-body">
                    <div style="height: 20px; text-align: center; vertical-align: middle"> Category </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-excerpt" class="collapsed header-text">
                    Excerpt
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-excerpt" class="collapse">
                <div class="panel-body">
                    <?php
                    echo $form->beginField($model, 'excerpt');
                    echo Html::activeTextarea($model, 'excerpt', ['class' => 'form-control', 'rows' => 3]);
                    echo Html::tag('div', Html::tag('small', Yii::t('post', 'Excerpts are optional hand-crafted summaries of your content. Add yours in the box above.')), ['class' => 'help-block']);
                    echo $form->endField();
                    ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-advance-settings" class="collapsed header-text">
                    Advanced Settings
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-advance-settings" class="collapse">
                <div class="panel-body">
                    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'visibility')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-advance-settings" class="collapsed header-text">
                    SEO
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-advance-settings" class="collapse">
                <div class="panel-body">

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'creator')->textInput() ?>

                    <?= $form->field($model, 'meta_data')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

                </div>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
