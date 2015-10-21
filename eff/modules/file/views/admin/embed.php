<?php
// common
$reloadGrid = $modal . "-file-library-pjax";
$uploadTab = $modal . "-upload-tab";
$filesTab = $modal . "-files-tab";
$ajaxRequest = \yii\helpers\Url::toRoute('/file/admin/ajax');
$staticDomain = Yii::$app->params['staticDomain'];
$jsConfig = new \yii\web\JsExpression('
    var embedModalConfiguration = {
        modal: "' . $modal . '",
        selectedItemContainer: "' . $modal . '-selected-items",
        selectedItemMode: "' . $selectMode . '",
        reloadGrid: "' . $reloadGrid . '",
        uploadTab: "' . $uploadTab . '",
        filesTab: "' . $filesTab . '",
        ajaxRequestUrl: "' . $ajaxRequest . '",
        staticDomain: "' . $staticDomain . '",
        bind: function(mode, id, name, date, size, resolution, url, title, alt, description) {
            var sidebarContainer = $("#" + this.modal + " .file-sidebar .file-info");
            if (mode == "show") {
                var fileDetails = name + "<br />" + date + "<br />" + size + "<br />" + resolution;
                sidebarContainer.find("span.file-id").html(id);
                sidebarContainer.find("img.file-thumb").attr("src", url);
                sidebarContainer.find("p.file-details").html(fileDetails);
                sidebarContainer.find("input.url").val(url);
                sidebarContainer.find("input.title").val(title);
                sidebarContainer.find("input.alt").val(alt);
                sidebarContainer.find("textarea.description").val(description);
                sidebarContainer.show();
            } else {
                sidebarContainer.hide();
            }
        },
        request: function(key) {
            var obj = this;
            if (key != "undefined" && !isNaN(key)) {
                $.ajax({
                    url: obj.ajaxRequestUrl + "?id=" + key,
                    type: "jsonp",
                    data: {' . Yii::$app->request->csrfParam . ': "' . Yii::$app->request->csrfToken . '"},
                    success: function(e) {
                        e = JSON.parse(e);
                        obj.bind("show", key, e.filename, e.date, "size", "resolution", obj.staticDomain + e.url, e.name, "alt", "description");
                    }
                });
            } else {
                obj.bind("hide");
            }
        }
    }
');
$this->registerJs($jsConfig, \yii\web\View::POS_END);

// dropzone
$dropZoneEvenHandler = [
    'queuecomplete' => new \yii\web\JsExpression('
        function(e) {
            var ids = [];
            this.files.forEach(function(e, i, a) {
                var xhr = JSON.parse(e.xhr.response);
                if (xhr.id != "undefined") {
                    ids[i] = xhr.id.toString();
                }
            });
            $("#" + embedModalConfiguration.selectedItemContainer).val(ids.join(","));
            $.pjax.reload({container: "#" + embedModalConfiguration.reloadGrid});
            this.removeAllFiles(e);
        }
    ')
];
$dropZoneOptions = [
    'acceptedFiles' => implode(',', [
        'image/*', 'video/*', 'audio/*', '.pdf', '.doc', '.xls', '.zip'
    ])
];

echo \yii\bootstrap\Tabs::widget([
    'navType' => 'nav-pills nav-goog-tabs',
    'itemOptions' => ['style' => 'margin: 15px 0;'],
    'items' => [
        [
            'label' => 'Upload files',
            'content' => $this->render("_form", ['modal' => $modal, 'dropZoneEvenHandler' => $dropZoneEvenHandler, 'dropZoneOptions' => $dropZoneOptions]),
            'options' => ['id' => $uploadTab]
        ],
        [
            'label' => 'Library',
            'content' => $this->render("_browse", ['dataProvider' => $dataProvider, 'modal' => $modal, 'reloadGrid' => $reloadGrid]),
            'options' => ['id' => $filesTab]
        ],
        [
            'label' => 'Upload a Link',
            'content' => 'Get link feature => later'
        ]
    ]
]);
