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
        selectedItems: [],
        template: function(mode) {
            if (mode == "basic") {

                var html = "";
                    html += "<div class=\"media\">";
                    html +=     "<h4 class=\"media-heading text-muted\">File #<span class=\"file-id\">{fileID}</span>";
                    html +=         "<a href=\"javascript:;\" class=\"btn btn-link btn-xs\"><span class=\"glyphicon glyphicon-edit\"></span> Edit</a>";
                    html +=         "<a href=\"javascript:;\" class=\"btn text-danger btn-xs\"><span class=\"glyphicon glyphicon-trash\"></span> Move to trash</a>";
                    html +=     "</h4>"
                    html +=     "<div class=\"media-left media-top\">";
                    html +=         "<a href=\"javascript:;\">";
                    html +=             "<img class=\"media-object file-thumb\" src=\"{fileUrl}\">";
                    html +=         "</a>";
                    html +=     "</div>";
                    html +=     "<div class=\"media-body\">";
                    html +=         "<p class=\"text-muted file-details\">{fileInfo}</p>";
                    html +=     "</div>";
                    html += "</div>";

                return "<div class=\"file-basic-info\">" + html + "</div>";

            } else if(mode == "public") {
                var html = "";
                    html += "<div class=\"form\">";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<input type=\"text\" readonly class=\"form-control\" value=\"{fileUrl}\"  placeholder=\"Url\">";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<input type=\"text\" class=\"form-control title\" value=\"{fileTitle}\" placeholder=\"Title\">";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<input type=\"text\" class=\"form-control alt\" value=\"{fileAlt}\" placeholder=\"Alt\">";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<textarea class=\"form-control description\" value=\"{fileDescription}\" placeholder=\"Description\"></textarea>";
                    html +=     "</div>";
                    html += "</div>";

                return "<div class=\"file-public-info\">" + html + "</div>";
            }
        },
        bind: function(mode, id, name, date, size, resolution, url, title, alt, description) {
            var sidebarContainer = $("#" + this.modal + " .file-sidebar .file-info");
            if (mode == "show") {
                var fileDetails = name + "<br />" + date + "<br />" + size + "<br />" + resolution;
                var basicInfo = this.template("basic").replaceAll("{fileID}", id).replaceAll("{fileUrl}", url).replaceAll("{fileInfo}", fileDetails);
                var publicInfo = this.template("public").replaceAll("{fileUrl}", url).replaceAll("{fileTitle}", title).replaceAll("{fileAlt}", alt).replaceAll("{fileDescription}", description);
                sidebarContainer.empty().append(basicInfo).append("<hr />").append(publicInfo);
                sidebarContainer.show();
            } else {
                sidebarContainer.hide().empty();
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
                        if (obj.selectedItemMode == "single") {
                            obj.selectedItems = [e];
                        } else if (selectedItemMode == "multiple") {
                            obj.selectedItems.push(e);
                        }
                    }
                });
            } else {
                obj.selectedItems = [];
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

$tabs = [];
$tabs[] = [
    'label' => 'Upload files',
    'content' => $this->render("_form", ['modal' => $modal, 'dropZoneEvenHandler' => $dropZoneEvenHandler, 'dropZoneOptions' => $dropZoneOptions]),
    'options' => ['id' => $uploadTab]
];
if ($withLibrary) {
    $tabs[] = [
        'label' => 'Library',
        'content' => $this->render("_browse", ['dataProvider' => $dataProvider, 'modal' => $modal, 'reloadGrid' => $reloadGrid]),
        'options' => ['id' => $filesTab]
    ];
}
if ($withFromLink) {
    $tabs[] = [
        'label' => 'Upload a Link',
        'content' => 'Get link feature => later'
    ];
}
echo \yii\bootstrap\Tabs::widget([
    'navType' => 'nav-pills nav-goog-tabs',
    'itemOptions' => ['style' => 'margin: 15px 0;'],
    'items' => $tabs
]);
