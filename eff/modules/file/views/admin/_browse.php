<?php \yii\widgets\Pjax::begin(['id' => $reloadGrid]); ?>
<div class="file-wrapper">
<?= $this->render("_search")?>
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
    ]
]) ?>
</div>
<?= $this->render("_sidebar") ?>
<?php \yii\widgets\Pjax::end(); ?>
<?php
$js = "
        ".$objectHandlerFunctions.".bindItemJs();

        // bind required fields
        $('#' + ".$objectHandlerFunctions.".filesTab).append('<input id=\"'+".$objectHandlerFunctions.".selectedItemContainer+'\" type=\"hidden\"/>');

        // bind on pjax completed and end
        $(document).on('pjax:end', function(e, options) {
            if (e.target.id == ".$objectHandlerFunctions.".reloadGrid) {
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
            }
        });
    ";
$this->registerJs($js);
?>
