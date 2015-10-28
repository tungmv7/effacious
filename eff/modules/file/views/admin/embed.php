<?php
// common
$pjaxTimeout = 20000;
$reloadGrid = $modal . "-file-library-pjax";
$uploadTab = $modal . "-upload-tab";
$filesTab = $modal . "-files-tab";
$ajaxRequest = \yii\helpers\Url::toRoute('/file/admin/ajax');
$staticDomain = Yii::$app->params['staticDomain'];
$isMultiple = json_encode($isMultiple);
$pjaxUrl = \yii\helpers\Url::toRoute(['/file/admin/embed', 'modal' => $modal, 'isMultiple' => $isMultiple, 'objectHandlerFunctions' => $objectHandlerFunctions, 'withLibrary' => $withLibrary, 'withFromLink' => $withFromLink, 'acceptedFiles' => $acceptedFiles]);
$jsConfig = new \yii\web\JsExpression('
    var '.$objectHandlerFunctions.' = {
        modal: "' . $modal . '",
        selectedItemContainer: "' . $modal . '-selected-items",
        isMultiple: ' . $isMultiple . ',
        reloadGrid: "' . $reloadGrid . '",
        uploadTab: "' . $uploadTab . '",
        filesTab: "' . $filesTab . '",
        ajaxRequestUrl: "' . $ajaxRequest . '",
        staticDomain: "' . $staticDomain . '",
        attachmentSize: 320,
        selectedItems: [],
        template: function(mode, extension) {
            if (mode == "basic") {

                var html = "";
                    html += "<div class=\"media\">";
                    html +=     "<h4 class=\"media-heading text-muted\">File #<span class=\"file-id\">{fileID}</span>";
                    html +=         "<a href=\"javascript:;\" class=\"btn btn-link btn-xs btn-edit\"><span class=\"glyphicon glyphicon-edit\"></span> Edit</a>";
                    html +=         "<a href=\"javascript:;\" class=\"btn text-danger btn-xs btn-remove\"><span class=\"glyphicon glyphicon-trash\"></span> Move to trash</a>";
                    html +=     "</h4>"
                    html +=     "<div class=\"media-left media-top\">";

                    if (extension == "image"){
                        html +=         "<a href=\"javascript:;\" class=\"file-image-mini\">";
                        html +=             "<img class=\"media-object file-thumb\" src=\"{fileUrl}\">";
                        html +=         "</a>";
                    } else {
                        html +=         "<div class=\"object-media file-extension\"><div><div><span class=\"glyphicon glyphicon-file\"></span>" + extension + "</div></div></div>";
                    }

                    html +=     "</div>";
                    html +=     "<div class=\"media-body\">";
                    html +=         "<p class=\"text-muted file-details\">{fileInfo}</p>";
                    html +=     "</div>";
                    html += "</div>";

                return "<div class=\"file-basic-info\">" + html + "</div>";

            } else if (mode == "public") {
                var html = "";
                    html += "<form class=\"form-horizontal file-editable-fields\">";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<label class=\"col-sm-3 control-label\">Url</label>";
                    html +=         "<div class=\"col-sm-9\"><input type=\"text\" readonly class=\"form-control\" value=\"{fileUrl}\"  placeholder=\"Url\"></div>";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<label class=\"col-sm-3 control-label\">Title</label>";
                    html +=         "<div class=\"col-sm-9\"><input type=\"text\" class=\"form-control input-editable-custom title\" name=\"title\" value=\"{fileTitle}\" placeholder=\"Title\"></div>";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<label class=\"col-sm-3 control-label\">Alt</label>";
                    html +=         "<div class=\"col-sm-9\"><input type=\"text\" class=\"form-control input-editable-custom alt\" name=\"alt\" value=\"{fileAlt}\" placeholder=\"Alt\"></div>";
                    html +=     "</div>";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<label class=\"col-sm-3 control-label\">Description</label>";
                    html +=         "<div class=\"col-sm-9\"><textarea class=\"form-control input-editable-custom description\" name=\"description\" placeholder=\"Description\">{fileDescription}</textarea></div>";
                    html +=     "</div>";
                    html +=     "<div class=\"loading-indicator\" style=\"display:none;\"><img src=\"/img/oval.svg\" width=\"20\"> Saving ...</div>";
                    html += "</form>";
                return "<div class=\"file-public-info\">" + html + "</div>";
            } else if (mode == "settings") {
                var html = "";
                    html += "<h4 class=\"text-muted\">Attachment Settings</h4>";
                    html += "<div class=\"form-horizontal\">";
                    html +=     "<div class=\"form-group form-group-sm\">";
                    html +=         "<label class=\"col-sm-3 control-label\">Size</label>";
                    html +=         "<div class=\"col-sm-9\"><select class=\"form-control attachment-size\">";
                    html +=             "<option value=\"160\">Small - 160px</option>";
                    html +=             "<option value=\"320\" selected>Medium - 320px</option>";
                    html +=             "<option value=\"640\">Large - 640px</option>";
                    html +=             "<option value=\"1280\">X-Large - 1280px</option>";
                    html +=             "<option value=\"0\">Full Size - {fileResolution}</option>";
                    html +=         "</select></div>";
                    html +=     "</div>";
                    html += "</div>";
                return "<div class=\"file-settings-info\">" + html + "</div>";
            }
        },
        bindItemJs: function(handler) {

            var objectHandler = this;

            $("#" + objectHandler.modal + " li.file-details").on("click", function(e) {

                // check selected mode
                var multiple = false;
                var isMultiple = objectHandler.isMultiple;
                if ((e.metaKey || e.ctrlKey) && isMultiple) {
                    multiple = true;
                }

                var key = $(this).data("key");
                var idsContainer = $("#" + objectHandler.selectedItemContainer);
                var ids = idsContainer.val().split(",").filter(function(el) {return el.length != 0});

                if (multiple) {
                    if ($(this).hasClass("selected")) {

                        // remove key from array
                        var index = ids.indexOf(key);
                        ids.splice(index, 1);

                        // remove class from un-selected item
                        $(this).removeClass("selected").removeClass("recent-selected");

                        // add recent selected class to li
                        var recentSelected = ids[ids.length - 1];
                        if (recentSelected != "undefined") {
                            $("#" + objectHandler.modal + " li.file-details[data-key=\'"+recentSelected+"\']").addClass("recent-selected");
                        }

                        // remove current un-selected values
                        objectHandler.bind("hide");

                    } else {

                        // remove all selected and recent selected class
                        $("#" + objectHandler.modal + "  li.file-details").removeClass("selected").removeClass("recent-selected");

                        // add recent selected class to li
                        var recentSelected = ids[ids.length - 1];
                        if (recentSelected != "undefined") {
                            $("#" + objectHandler.modal + " li.file-details[data-key=\'"+recentSelected+"\']").addClass("recent-selected");
                        }

                        // add class to selected item
                        $(this).addClass("active selected");

                        // bind current selected values
                        var data = objectHandler.request(parseInt(key));
                        if (data !== false) {
                            objectHandler.bind("show", data);
                        }

                        // push key to array to store
                        ids.push(key.toString());
                    }
                } else {
                    if ($(this).hasClass("selected")) {

                        // remove active and selected from un-selected item
                        $(this).removeClass("selected").removeClass("active");

                        // remove key from array
                        var index = ids.indexOf(key);
                        ids.splice(index, 1);

                        // remove current un-selected values
                        objectHandler.bind("hide");

                    } else {
                        // remove all current active and selected item
                        var selectedItems = $("#" + objectHandler.modal + " .file-wrapper").find("li.file-details.selected");
                        if (selectedItems != "undefined" && selectedItems.length > 0) {
                            for(i = 0; i < selectedItems.length; i++) {
                                var selectedItem = selectedItems[i];
                                var selectedItemKey = $(selectedItem).data("key").toString();
                                var index = ids.indexOf(selectedItemKey);
                                ids.splice(index, 1);
                                $("#" + objectHandler.modal + " li.file-details[data-key=\'"+selectedItemKey+"\']").removeClass("selected").removeClass("active");
                            }
                        }

                        // add active and selected class to selected item
                        $(this).addClass("active").addClass("selected");

                        // push key to array to store
                        ids.push(key.toString());

                        // bind current selected values
                        var data = objectHandler.request(parseInt(key));
                        if (data !== false) {
                            objectHandler.bind("show", data);
                        }
                    }
                }
                objectHandler.selectedItems = objectHandler.selectedItems.filter(function(el) {return ids.indexOf(el.id.toString()) !== -1;});
                idsContainer.val(ids.join(","));
            });
        },
        bind: function(mode, raw) {
            var obj = this;
            var sidebarContainer = $("#" + this.modal + " .file-sidebar .file-info");
            if (mode == "show") {
                var customExtension = raw.type.indexOf("image") === 0 ? "image" : raw.extension;
                if (customExtension == "image") {
                    var fileDetails = "<strong>" + raw.name + "</strong>" + "<br />Created at " + raw.date + "<br />" + raw.metadata.size + " - " + raw.metadata.resolution.w + "x" + raw.metadata.resolution.h;
                } else {
                    var fileDetails = "<strong>" + raw.name + "</strong>" + "<br />Created at " + raw.date + "<br />" + raw.metadata.size;
                }
                var basicInfo = this.template("basic", customExtension).replaceAll("{fileID}", raw.id).replaceAll("{fileUrl}", raw.url + "?w=150").replaceAll("{fileInfo}", fileDetails);
                var publicInfo = this.template("public").replaceAll("{fileUrl}", raw.url + "?w=150").replaceAll("{fileTitle}", raw.title).replaceAll("{fileAlt}", raw.alt).replaceAll("{fileDescription}", raw.description);
                sidebarContainer.empty().append(basicInfo).append(publicInfo);
                if (customExtension == "image") {
                    var settingsInfo = this.template("settings").replaceAll("{fileResolution}", raw.metadata.resolution.w + "px");
                    sidebarContainer.append("<hr />").append(settingsInfo);
                    $("#" + this.modal + " .file-sidebar .file-info .attachment-size").on("change", function(e) {
                        obj.attachmentSize = this.value;
                    });
                }
                sidebarContainer.show();

                $("#" + obj.modal + " .file-sidebar .file-info a.file-image-mini").on("click", function(e) {
                    var wrapper = $("#" + obj.modal + " .file-wrapper");
                    var grid = $("#" + obj.modal + " #" + obj.reloadGrid);
                    console.log(wrapper);
                    console.log(grid);
                    if (grid.hasClass("hidden")) {
                        grid.removeClass("hidden");
                        wrapper.find(".file-image-fullsize").remove();
                        console.log(e);
                    } else {
                        wrapper.prepend("<div class=\"file-image-fullsize\"><div><img src=\""+raw.url+"\" /></div></div>");
                        grid.addClass("hidden");
                        console.log(e);
                    }
                    console.log(grid.hasClass("hidden"));
                });

                $("#" + this.modal +" .file-sidebar .file-info .file-editable-fields .input-editable-custom").on("change", function(e) {
                    var loadingIndicator = $(this).parents(".file-editable-fields").find(".loading-indicator");
                    var formData = $(this).parents(".file-editable-fields").serialize();
                    formData += "&' . Yii::$app->request->csrfParam . '=' . Yii::$app->request->csrfToken . '";
                    $.ajax({
                        url: obj.ajaxRequestUrl + "?mode=update&id=" + raw.id,
                        type: "jsonp",
                        data: formData,
                        type: "POST",
                        beforeSend: function(e) {
                            loadingIndicator.fadeIn();
                        },
                        complete: function(e) {
                            loadingIndicator.fadeOut("slow");
                        }
                    });
                });

            } else {
                sidebarContainer.hide().empty();
            }
        },
        getAttachment: function(item) {
            if (item.type.indexOf("image") === 0) {
                var size = this.attachmentSize;
                var link = (size !== "0") ? item.url+"?w="+size : item.url;
                return "<img src=\""+link+"\" \/\>";
            } else {
                return "<a href=\""+item.url+"\">"+item.name+"</a>"
            }
        },
        request: function(key) {
            var objectHandler = this;
            var result;
            $.ajax({
                url: objectHandler.ajaxRequestUrl + "?id=" + key,
                type: "jsonp",
                data: {' . Yii::$app->request->csrfParam . ': "' . Yii::$app->request->csrfToken . '"},
                async: false,
                success: function(e) {
                    e = JSON.parse(e);
                    objectHandler.selectedItems.push(e);
                    result = e;
                },
                error: function(e) {
                    result = false;
                }
            });
            return result;
        }
    }
');
$this->registerJs($jsConfig, \yii\web\View::POS_END); // POST_END to register js to window object

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
            $("#" + '.$objectHandlerFunctions.'.selectedItemContainer).val(ids.join(","));
            $.pjax.reload({container: "#" + '.$objectHandlerFunctions.'.reloadGrid, push: false, replace: false, timeout: '.$pjaxTimeout.', url: "'.$pjaxUrl.'"});
            this.removeAllFiles(e);
        }
    ')
];
$dropZoneOptions = [
    'acceptedFiles' => implode(',', (array) $acceptedFiles)
];

$tabs = [];
$tabs[] = [
    'label' => 'Upload files',
    'content' => $this->render("_form", ['modal' => $modal, 'dropZoneEvenHandler' => $dropZoneEvenHandler, 'dropZoneOptions' => $dropZoneOptions]),
    'options' => ['id' => $uploadTab]
];

if ($withLibrary === true) {
    if (!isset($dataProvider)) {
        $dataProvider = new \yii\data\ArrayDataProvider();
        $jsOnLoad = '
        $("a[href=\"#'.$filesTab.'\"]").on("show.bs.tab", function (e) {
            $.pjax.reload({container: "#" + '.$objectHandlerFunctions.'.reloadGrid, push: false, replace: false, timeout: '.$pjaxTimeout.', url: "'.$pjaxUrl.'"});
        });
        ';
        $this->registerJs($jsOnLoad);
    }
    if (!isset($searchModel)) {
        $searchModel = new \eff\modules\file\models\FileSearch();
    }
    $tabs[] = [
        'label' => 'Library',
        'content' => $this->render("_browse", [
            'objectHandlerFunctions' => $objectHandlerFunctions,
            'dataProvider' => $dataProvider,
            'modal' => $modal, 'reloadGrid' => $reloadGrid,
            'searchModel' => $searchModel,
            'pjaxUrl' => $pjaxUrl,
            'pjaxTimeout' => $pjaxTimeout
        ]),
        'options' => ['id' => $filesTab]
    ];
}
if ($withFromLink === true) {
    $tabs[] = [
        'label' => 'Upload a Link',
        'content' => 'Get link feature => later'
    ];
}
echo \yii\helpers\Html::beginTag('div', ['class' => 'eff-files', 'id' => $modal, 'data-handler' => $objectHandlerFunctions]);
echo \yii\bootstrap\Tabs::widget([
    'navType' => 'nav-pills nav-goog-tabs',
    'itemOptions' => ['style' => 'margin: 15px 0;'],
    'items' => $tabs
]);
echo \yii\helpers\Html::endTag('div');
