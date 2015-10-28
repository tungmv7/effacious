<div class="file-wrapper">
<?php \yii\widgets\Pjax::begin(['id' => $reloadGrid, 'enablePushState' => false, 'enableReplaceState' => false, 'timeout' => $pjaxTimeout]); ?>
<?= $this->render("_search", ['model' => $searchModel, 'pjaxUrl' => $pjaxUrl])?>
<?= \eff\components\ListView::widget([
    'dataProvider' => $dataProvider,
    'itemView' => '_item',
    'itemOptions' => [
        'tag' => 'li',
        'class' => 'file-details',
    ],
    'options' => [
        'tag' => 'ul',
        'class' => 'file-wrapper-thumbs'
    ],
    'emptyText' => \yii\helpers\Html::tag('div', 'No items found.', ['class' => 'centered']),
    'emptyTextOptions' => ['class' => 'empty file-empty']
]) ?>
</div>
<?= $this->render("_sidebar") ?>
<?php \yii\widgets\Pjax::end(); ?>
<?php
$js = "
        ".$objectHandlerFunctions.".bindItemJs();

        // bind required fields
        $('#' + ".$objectHandlerFunctions.".filesTab).append('<input id=\"'+".$objectHandlerFunctions.".selectedItemContainer+'\" type=\"hidden\"/>');

        $('#".$reloadGrid."').on('pjax:start', function(e, options) {
            $(this).find('.loading-indicator').show();
        });

        // bind on pjax completed and end
        $('#".$reloadGrid."').on('pjax:end', function(e, options) {
            var ids = $('#' + ".$objectHandlerFunctions.".selectedItemContainer).val().split(',').filter(function(el) {return el.length != 0});
            ids.forEach(function(id, i, a) {
                var li = $('#' + ".$objectHandlerFunctions.".modal + ' li.file-details[data-key=\"'+id+'\"]').addClass('active selected');
                var data = ".$objectHandlerFunctions.".request(parseInt(id));
                if (data !== false) {
                    ".$objectHandlerFunctions.".bind('show', data);
                }
            });
            $('#' + ".$objectHandlerFunctions.".modal + \" a[href='#\"+".$objectHandlerFunctions.".filesTab+\"']\").tab('show');
            ".$objectHandlerFunctions.".bindItemJs();
            $(this).find('.loading-indicator').hide();
        });
    ";
$this->registerJs($js);
?>
