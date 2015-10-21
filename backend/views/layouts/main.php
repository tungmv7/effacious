<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<!--    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs/dt-1.10.9/datatables.min.css"/>-->
<!--    <script type="text/javascript" src="https://cdn.datatables.net/r/bs/dt-1.10.9/datatables.min.js"></script>-->
</head>
<body>
<?php $this->beginBody() ?>

<?php
NavBar::begin([
    'brandLabel' => 'EFI Content System',
    'brandUrl' => Yii::$app->homeUrl,
    'options' => [
        'class' => 'navbar-inverse navbar-fixed-top',
    ],
    'innerContainerOptions' => [
        'class' => 'container-fluid'
    ]
]);
$menuItems = [
    ['label' => 'Home', 'url' => ['/site/index']],
];
if (Yii::$app->user->isGuest) {
    $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
} else {
    $menuItems[] = [
        'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
        'url' => ['/site/logout'],
        'linkOptions' => ['data-method' => 'post']
    ];
}
echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $menuItems,
]);
NavBar::end();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <?php
            if (!empty($this->params['menu'])) {
                echo Nav::widget([
                    'items' => $this->params['menu'],
                    'options' => [
                        'class' => 'nav nav-sidebar'
                    ]
                ]);
            }
            ?>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
            <?//= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
            <?= $content ?>
        </div>
    </div>


    <div class="eff-modal modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <div class="loading-indicator">
                        <img src="/img/puff.svg" width="50"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        $modalJs = "
            $('.eff-modal').on('shown.bs.modal', function (event) {
                var trigger = $(event.relatedTarget);
                var modal = trigger.data('target'), reload = trigger.data('reload');
                if (modal !== 'undefined'){
                    $(modal).modal('hide');
                }
                if (reload !== 'undefined') {
                    $.pjax.reload({container: reload, async: false});
                }
            });

            $('.eff-modal').on('show.bs.modal', function (event) {
                var trigger = $(event.relatedTarget);
                var url = trigger.data('url'), params = trigger.data('params');
                if (url !== 'undefined' && params !== 'undefined') {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: params,
                        error: function(err) {},
                        success: function(data) {}
                    });
                }
            });
        ";
        $this->registerJs($modalJs);

        $js = "
            function reload(id) {
                $('.modal').modal('hide');
                $.pjax.reload({container: '#' + id});
            }
        ";
        $this->registerJs($js, \yii\web\View::POS_END);

    ?>


</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
