<?php
use yii\helpers\Html;
use \eff\components\ActiveForm;

/* @var $this yii\web\View */
/* @var $model eff\modules\post\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form row">
    <?php

    // IMPORTANT: must place this code before form to execute pjax
    echo eff\modules\file\widgets\FileModal::widget([
        'id' => 'post-featured-image-modal',
        'header' => Html::tag('h4', 'Featured Image', ['class' => 'modal-title']),
        'footer' => Html::a('Close', '#', ['class' => 'btn', 'data-dismiss' => 'modal']) . "\n" . Html::a("Set featured image", 'javascript:;', ['class' => 'btn btn-primary btn-sm btn-set-featured-image']),
        'params' => ['isMultiple' => false, 'acceptedFiles' => 'image/*']
    ]);
    $js = "
        $('.btn-set-featured-image').on('click', function(e) {
            var embedModalConfiguration = window[$(this).parents('.modal').find('.eff-files').data('handler')];
            if (Array.isArray(embedModalConfiguration.selectedItems) && embedModalConfiguration.selectedItems.length > 0) {
                var item = embedModalConfiguration.selectedItems[0];
                var attachment = embedModalConfiguration.getAttachment(item);
                $('#".Html::getInputId($model, 'featured_image')."').val(item.id);
                $('.featured-image-select').find('.default-image').hide();
                $('.featured-image-select').find('.btn-choose-featured-image').attr('class', 'btn-choose-featured-image').html(attachment);
                $('#post-featured-image-modal').modal('toggle');
            }
        })
    ";
    $this->registerJs($js, \yii\web\View::POS_END);

    echo eff\modules\file\widgets\FileModal::widget([
        'id' => 'post-media-modal',
        'header' => Html::tag('h4', 'Insert a media', ['class' => 'modal-title']),
        'footer' => Html::a('Close', '#', ['class' => 'btn', 'data-dismiss' => 'modal']) . "\n" . Html::a("Insert to post", 'javascript:;', ['class' => 'btn btn-primary btn-sm btn-insert-to-post']),
        'params' => ['isMultiple' => true]
    ]);
    $js = "
        $('.btn-insert-to-post').on('click', function(e) {
            var embedModalConfiguration = window[$(this).parents('.modal').find('.eff-files').data('handler')];
            if (Array.isArray(embedModalConfiguration.selectedItems) && embedModalConfiguration.selectedItems.length > 0) {
                embedModalConfiguration.selectedItems.forEach(function(item, index) {
                    var attachment = embedModalConfiguration.getAttachment(item);
                    var redactorId = '".Html::getInputId($model, 'body')."';
                    $('#'+redactorId).redactor('insert.html', '<p>' + attachment + '</p>');
                });

                $('#post-media-modal').modal('toggle');
            }
        })
    ";
    $this->registerJs($js, \yii\web\View::POS_END);

    ?>

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <?= \eff\widgets\Alert::widget() ?>
        <?= $form->errorSummary($model); ?>
    </div>
    <?php $isNewRecord = $model->getIsNewRecord(); ?>
    <div class="col-md-8">

        <div class="form-group">
            <?= Html::submitButton(Yii::t('post', 'Preview'), ['class' => 'btn btn-primary btn-sm']) ?>
            <?php if(!$isNewRecord) echo Html::a(Html::tag('span', '',['class' => 'glyphicon glyphicon-trash']) . ' ' .Yii::t('post', 'Move to trash'), '#', ['class' => 'btn btn-trash btn-sm text-danger']) ?>
            <?= Html::a($isNewRecord ? Yii::t('post', 'Publish Immediately') : Yii::t('post', 'Update'), '', ['class' => 'btn btn-success btn-submit pull-right btn-sm']) ?>
            <?php if($isNewRecord) echo Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-floppy-disk']) . ' ' .Yii::t('post', 'Save as Draft'), '', ['class' => 'btn pull-right btn-sm text-muted btn-save-draft']) ?>
        </div>
        <script>
            <?php
            $js = "
                $('.btn-save-draft').on('click', function(e) {
                        var draftStatus = '".$model::STATUS_DRAFT."';
                    var statusElement = '#".Html::getInputId($model, 'status')."';
                    var formElement = '#".$form->getId()."';
                    $(statusElement).val(draftStatus);
                    $(formElement).submit();
                    return false;
                });
                $('.btn-submit').on('click', function(e) {
                    var formElement = '#".$form->getId()."';
                    $(formElement).submit();
                });

                $('.btn-trash').on('click', function(e) {
                    if (window.confirm('".Yii::t('post', 'Are you sure you want to do this ?')."') ) {
                        var postId = getParameterByName('id');
                        var deleteUrl = '".\yii\helpers\Url::toRoute(['delete'])."';
                        if (postId !== 'undefined') {
                            $.post(deleteUrl + '?id=' + postId);
                        }
                    }
                });
            ";
            $this->registerJs($js);
            ?>
        </script>

        <?php
        // post name
        echo $form->beginField($model, 'name');
        echo Html::activeInput('text', $model, 'name', ['class' => 'form-control', 'maxlength' => true, 'placeholder' => Yii::t('post', 'Title') . ' ...']);
        echo Html::beginTag('div', ['class' => 'help-block slug-buttons']);
            echo \eff\modules\post\widgets\SlugWidget::widget([
                'model' => $model,
                'attribute' => 'slug',
                'autoDetectId' => $isNewRecord ? "#" . Html::getInputId($model, 'name') : false,
                'baseUrl' => 'http://f.dev/post/2015/10/02/',
            ]);
        echo Html::endTag('div');
        echo $form->endField();

        // post body - content
        echo $form->beginField($model, 'body');
//        echo \eff\widgets\textboxio\TextboxIO::widget([
//            'model' => $model,
//            'attribute' => 'body',
//            'clientOptions' => [
//                'ui' => [
//                    'toolbar' => [
//                        'items' => [
//                            [
//                                'label' => 'Insert group',
//                                'items' => [
//                                    [
//                                        'id' => 'media',
//                                        'text' => 'Insert media',
//                                        'action' => 'function(){alert("Custom Button 1 Clicked");}'
//                                    ],
//                                    'media', 'link', 'table', 'specialchar', 'hr'
//                                ]
//                            ],
//                            'undo', 'style', 'emphasis', 'align', 'listindent', 'format', 'tools'
//                        ]
//                    ],
//                ],
//                'paste' => [
//                    'style' => 'clean'
//                ],
//                'images' => [
//                    'allowLocal' => false
//                ]
//            ]
//        ]);
        echo \eff\widgets\redactor\Redactor::widget([
            'model' => $model,
            'attribute' => 'body',
            'clientOptions' => [
                'minHeight' => '400px',
                'maxHeight' => '600px',
                'placeholder' => Yii::t('post', 'Enter your awesome content ...'),
                'plugins' => ['video', 'media']
            ]
        ]);
        echo Html::error($model, 'body', ['class' => 'help-block']);
        echo $form->endField();
        ?>

    </div>
    <div class="col-md-4">
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-published-status" class="collapsed publish-status header-text">
                    Publish Status
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
                <?= Html::label(Html::tag('small', $isNewRecord ? 'Current status: <strong>new draft</strong>' : 'Current status: <strong>'. $model->status . '</strong>'), null, ['class' => 'text-normal text-current-status']) ?>
                </div>
            <div id="post-published-status" class="collapse">
                <div class="panel-body">
                    <?= Html::activeHiddenInput($model, 'published_at') ?>
                    <?= Html::activeHiddenInput($model, 'status') ?>
                    <?= Html::activeHiddenInput($model, 'version') ?>
                    <?= Html::radioList('status', $model::SAVE_OPTION_PUBLISH_IMMEDIATELY, $model::getSaveOptions(), ['class' => 'radio radio-list radio-save-status']) ?>
                    <div>
                        <div class="schedule-date">
                            <?= \eff\widgets\datetimepicker\DateTimePickerWidget::widget([
                                'name' => 'publish_schedule_date',
                                'value' => date('dd-mm-Y', time()),
                                'clientOptions' => [
                                    'format' => 'DD-MM-YYYY',
                                    'useCurrent' => true
                                ],
                                'options' => [
                                    'class' => 'form-control input-sm'
                                ]
                            ])?>
                        </div>
                        <div class="schedule-time">
                            <?= \eff\widgets\datetimepicker\DateTimePickerWidget::widget([
                                'name' => 'publish_schedule_time',
                                'value' => date('H:i', time()),
                                'withTriggerIcon' => 'glyphicon glyphicon-time',
                                'clientOptions' => [
                                    'format' => 'HH:mm',
                                    'useCurrent' => true
                                ],
                                'options' => [
                                    'class' => 'form-control input-sm'
                                ]
                            ])?>
                        </div>
                    </div>
                    <?php
                    $js = "
                        $('.radio-save-status').on('change', function (e) {
                            var text = e.target.nextSibling.nodeValue.trim();
                            var value = e.target.value;
                            var pendingStatus = '".$model::STATUS_PENDING."';
                            var publishedStatus = '".$model::STATUS_PUBLISHED."';
                            var statusElement = '#".Html::getInputId($model, 'status')."';
                            if (text != 'undefined' && value != 'undefined') {
                                $('.btn-submit').html(e.target.nextSibling.nodeValue.trim());
                                if (value == 'publish_immediately') {
                                    $(statusElement).val(publishedStatus);
                                    $('.btn-submit').removeClass('btn-info').removeClass('btn-warning').addClass('btn-success')
                                } else if (value == 'publish_scheduled') {
                                    $(statusElement).val(publishedStatus);
                                    $('.btn-submit').removeClass('btn-success').removeClass('btn-warning').addClass('btn-info')
                                } else if (value == 'pending_review') {
                                    $(statusElement).val(pendingStatus);
                                    $('.btn-submit').removeClass('btn-info').removeClass('btn-success').addClass('btn-warning')
                                }
                            }
                        })
                    ";
                    $this->registerJs($js);
                    ?>
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
                        <a class="default-image"><i class="glyphicon glyphicon-picture"></i></a>
                        <?= Html::activeHiddenInput($model, 'featured_image') ?>
                        <?= Html::a(Yii::t('post', 'Choose featured image'), '#', ['class' => 'btn btn-primary btn-xs btn-choose-featured-image', 'data-toggle' => 'modal', 'data-target' => '#post-featured-image-modal']) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-categories" class="header-text">
                    Categories
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-categories" class="collapse in">
                <div class="panel-body">
                    <div style="height: 20px; text-align: center; vertical-align: middle"> Categories</div>
                </div>
            </div>
        </div>
        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#post-tags" class="header-text">
                    Tags
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="post-tags" class="collapse in">
                <div class="panel-body">
                    <div style="height: 20px; text-align: center; vertical-align: middle"> Tags</div>
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

                    <?= $form->field($model, 'creator')->textInput() ?>

                    <?= $form->field($model, 'type')->dropDownList($model->getFormatTypes()) ?>

                    <?= $form->field($model, 'visibility')->dropDownList($model->getVisibilityTypes()) ?>

                    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="panel panel-default panel-post">
            <div class="panel-heading">
                <a data-toggle="collapse" href="#seo-settings" class="collapsed header-text">
                    SEO
                    <span class="pull-right glyphicon glyphicon-menu-down" aria-hidden="true"></span>
                    <span class="pull-right glyphicon glyphicon-menu-up" aria-hidden="true"></span>
                </a>
            </div>
            <div id="seo-settings" class="collapse">
                <div class="panel-body">

                    <?= $form->field($model, 'seo_title')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'seo_description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'seo_keywords')->textarea(['rows' => 6]) ?>

                </div>
            </div>
        </div>

    </div>
</div>
    <?php ActiveForm::end(); ?>


