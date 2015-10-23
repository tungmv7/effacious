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
<?php
    $jsBindOnPjax = "
        $('#' + embedModalConfiguration.modal + ' li.file-details').on('click', function(e) {

            // check selected mode
            var multiple = false;
            var selectedMode = embedModalConfiguration.selectedItemMode;
            if ((e.metaKey || e.ctrlKey) && selectedMode != 'single') {
                multiple = true;
            }

            var key = $(this).data('key');
            var idsContainer = $('#' + embedModalConfiguration.selectedItemContainer);
            var ids = idsContainer.val().split(',').filter(function(el) {return el.length != 0});

            if (multiple) {
                if ($(this).hasClass('selected')) {

                    // remove key from array
                    var index = ids.indexOf(key);
                    ids.splice(index, 1);

                    // remove class from un-selected item
                    $(this).removeClass('selected').removeClass('recent-selected');

                    // add recent selected class to li
                    var recentSelected = ids[ids.length - 1];
                    if (recentSelected != 'undefined') {
                        $('#' + embedModalConfiguration.modal + ' li.file-details[data-key=\"'+recentSelected+'\"]').addClass('recent-selected');
                    }

                    // remove current un-selected values
                    embedModalConfiguration.request('undefined');

                } else {

                    // remove all selected and recent selected class
                    $('#' + embedModalConfiguration.modal + '  li.file-details').removeClass('selected').removeClass('recent-selected');

                    // add recent selected class to li
                    var recentSelected = ids[ids.length - 1];
                    if (recentSelected != 'undefined') {
                        $('#' + embedModalConfiguration.modal + ' li.file-details[data-key=\"'+recentSelected+'\"]').addClass('recent-selected');
                    }

                    // add class to selected item
                    $(this).addClass('active selected');

                    // bind current selected values
                    embedModalConfiguration.request(parseInt(key));

                    // push key to array to store
                    ids.push(key.toString());
                }
            } else {
                if ($(this).hasClass('selected')) {

                    // remove active and selected from un-selected item
                    $(this).removeClass('selected').removeClass('active');

                    // remove key from array
                    var index = ids.indexOf(key);
                    ids.splice(index, 1);

                    // remove current un-selected values
                    embedModalConfiguration.request('undefined');

                } else {
                    // remove all current active and selected item
                    var selectedItems = $('#' + embedModalConfiguration.modal + ' .file-wrapper').find('li.file-details.selected');
                    if (selectedItems != 'undefined' && selectedItems.length > 0) {
                        for(i = 0; i < selectedItems.length; i++) {
                            var selectedItem = selectedItems[i];
                            var selectedItemKey = $(selectedItem).data('key').toString();
                            var index = ids.indexOf(selectedItemKey);
                            ids.splice(index, 1);
                            $('#' + embedModalConfiguration.modal + ' li.file-details[data-key=\"'+selectedItemKey+'\"]').removeClass('selected').removeClass('active');
                        }
                    }

                    // add active and selected class to selected item
                    $(this).addClass('active').addClass('selected');

                    // push key to array to store
                    ids.push(key.toString());

                    // bind current selected values
                    embedModalConfiguration.request(parseInt(key));
                }
            }

            idsContainer.val(ids.join(','));
        });
    ";
    $this->registerJs($jsBindOnPjax, \yii\web\View::POS_END);
?>
<?php \yii\widgets\Pjax::end(); ?>
<?php
$js = "
        // bind required fields
        $('#' + embedModalConfiguration.filesTab).append('<input id=\"'+embedModalConfiguration.selectedItemContainer+'\" type=\"hidden\"/>');

        // bind on pjax completed and end
        $(document).on('pjax:end', function(e, options) {
            if (e.target.id == embedModalConfiguration.reloadGrid) {
                var ids = $('#' + embedModalConfiguration.selectedItemContainer).val().split(',').filter(function(el) {return el.length != 0});
                ids.forEach(function(id, i, a) {
                    var li = $('#' + embedModalConfiguration.modal + ' li.file-details[data-key=\"'+id+'\"]').addClass('active selected');
                    if (++i == ids.length) {
                        embedModalConfiguration.request(id);
                    }
                });
                $('#' + embedModalConfiguration.modal + \" a[href='#\"+embedModalConfiguration.filesTab+\"']\").tab('show');
            }
        });
    ";
$this->registerJs($js, \yii\web\View::POS_END);
?>
