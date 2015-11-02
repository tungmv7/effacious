<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel eff\modules\tree\models\TreeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('file', 'Trees');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tree-index content">

    <div class="page-header">
        <h3>
            <?= Html::encode($this->title) ?>
            <?= Html::a(Yii::t('post', 'Add new tree'), ['create'], ['class' => 'btn bg-warning text-muted btn-xs']) ?>
        </h3>
    </div>

    <div class="eff-tree">
        <div class="eff-tree-sidebar">
            <div class="eff-tree-sidebar-header">
                <input type="text" class="form-control input-sm" placeholder="Search ..." />
            </div>
            <div class="eff-tree-sidebar-content">
            <?php
//                \yii\widgets\Pjax::begin(['id' => 'tree-pjax']);
                echo \eff\modules\tree\widgets\tree\TreeWidget::widget([
                    'name' => 'category',
                    'options' => ['id' => 'category'],
                    'clientOptions' => [
                        'core' => [
                            'themes' => ['name' => 'default', 'responsive' => true, 'variant' => "large"],
                            'check_callback' => true,
                            'force_text' => true,
                            'multiple' => false,
                            'data' => [
                                'url' => \yii\helpers\Url::toRoute('/tree/admin/ajax'),
                                'dataType' => 'json',
                                'data' => new \yii\web\JsExpression("function (node) {
                                    if (isNaN(node.id)) { return {}; } else {return { 'id' : node.id };}

                                }")
                            ]
                        ],
                        'plugins' => ['changed'],
                    ]
                ]);
//                \yii\widgets\Pjax::end();
            ?>
            </div>
            <div class="eff-tree-sidebar-footer">
                <a href="javascript:;" class="btn btn-xs btn-default" onclick="demo_create();"><i class="glyphicon glyphicon-plus"></i> Add new</a>
                <a href="javascript:;" class="btn btn-xs btn-default" onclick="demo_delete();"><i class="glyphicon glyphicon-minus"></i> Remove</a>
                <a href="javascript:;" class="btn btn-xs btn-default" onclick="demo_rename();"><i class="glyphicon glyphicon-edit"></i> Edit</a>

                <script type="text/javascript">
                    $('#category').on("set_text.jstree", function(e, data) {
                        console.log(e);
                        console.log(data);
//                        console.log("set_text");
                    });
                    $('#category').on("changed.jstree", function(e, data) {
//
                        console.log(e);
                        console.log(data);
////                        if (data.action == "select_node") {
                            var clickedItem = data.node.id
                            $.pjax.reload({container : '#tree-form-pjax', push: false, replace: false, url: "<?= \yii\helpers\Url::toRoute(['/tree/admin/tree']) ?>?id="+clickedItem, timeout: 20000});
////                        }
//
                    });
                    function demo_create() {
                        var ref = $('#category').jstree(true),
                            sel = ref.get_selected(); console.log(sel);
                        if(!sel.length) { return false; }
                        sel = sel[0];
                        sel = ref.create_node(sel, {"type":"file"});
                        if(sel) {
                            ref.edit(sel);
                            ref.select_node(sel);
                        }
                    };
                    function demo_rename() {
                        var ref = $('#category').jstree(true),
                            sel = ref.get_selected();
                        if(!sel.length) { return false; }
                        sel = sel[0];
                        ref.edit(sel);
                    };
                    function demo_delete() {
                        var ref = $('#category').jstree(true),
                            sel = ref.get_selected();
                        if(!sel.length) { return false; }
                        ref.delete_node(sel);
                    };

                </script>
            </div>
        </div>
        <div class="eff-tree-wrapper">
            <?php \yii\widgets\Pjax::begin(['id' => 'tree-form-pjax', 'enablePushState' => false, 'enableReplaceState' => false]); ?>
                <?php
                    echo $this->render("_form", ['model' => $model]);
                ?>
            <?php \yii\widgets\Pjax::end(); ?>
        </div>
    </div>

</div>
