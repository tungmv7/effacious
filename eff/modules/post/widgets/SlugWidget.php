<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 9:29 PM
 */

namespace eff\modules\post\widgets;

use Yii;
use yii\bootstrap\Html;
use yii\web\JsExpression;
use yii\web\View;
use yii\widgets\InputWidget;

class SlugWidget extends InputWidget
{
    public $baseUrl;
    public $autoDetectId = false;

    private $_slugValue;
    private $_slugElement;

    public function run()
    {
        $options = ['class' => 'slug-editable', 'id' => $this->id . '-slug'];

        if ($this->autoDetectId !== false) {
            $options['style'] = 'display:none;';
        }
        echo Html::beginTag('div', $options);

        if ($this->hasModel()) {
            echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
            $this->_slugValue = Html::getAttributeValue($this->model, $this->attribute);
            $this->_slugElement = "#" . Html::getInputId($this->model, $this->attribute);
        } else {
            echo Html::hiddenInput($this->name, $this->value, $this->options);
            $this->_slugValue = $this->value;
            $this->_slugElement = "input[name=" . $this->name . "]";
        }

        echo Html::tag('small', $this->baseUrl . '<p class="raw-slug">' . $this->_slugValue . '</p>', ['class' => 'slug']);
        echo Html::button(Yii::t('post', 'Edit'), ['class' => 'btn btn-default btn-xs btn-slug-non-editable', 'data-action' => 'change']);
        echo Html::button(Yii::t('post', 'View'), ['class' => 'btn btn-default btn-xs btn-slug-non-editable', 'data-action' => 'view']);
        echo Html::button(Yii::t('post', 'Save'), ['class' => 'btn btn-default btn-xs btn-slug-editable', 'data-action' => 'save', 'style' => 'display:none;']);
        echo Html::button(Yii::t('post', 'Cancel'), ['class' => 'btn btn-default btn-xs btn-slug-editable', 'data-action' => 'cancel', 'style' => 'display:none;']);

        $view = $this->getView();

        $js = new JsExpression('
            $("#' . $this->id . '-slug .btn-slug-non-editable").on("click", function(e) {
                var wrapper = $(this).parent();
                var action = $(this).data("action");
                if (action == "change") {
                    var slug = $("' . $this->_slugElement . '").val();
                    wrapper.find(".raw-slug").html("<input type=\"text\" value=\""+slug+"\"/>");
                    $("#' . $this->id . '-slug .btn-slug-non-editable").hide();
                    $("#' . $this->id . '-slug .btn-slug-editable").show();
                    wrapper.find(".raw-slug").find("input[type=text]").focus();
                } else if (action == "view") {
                    window.open(wrapper.find(".raw-slug").html(), "_blank");
                }
            });

            $("#' . $this->id . '-slug .btn-slug-editable").on("click", function(e) {
                var wrapper = $(this).parent();
                var action = $(this).data("action");
                var slugElement = $("' . $this->_slugElement . '");
                if (action == "save") {
                    var newRawSlug = wrapper.find(".raw-slug").find("input[type=text]").val();
                    slugElement.val(newRawSlug.toSlug(false, true));
                }
                wrapper.find(".raw-slug").html(slugElement.val());
                $("#' . $this->id . '-slug .btn-slug-editable").hide();
                $("#' . $this->id . '-slug .btn-slug-non-editable").show();
            });
        ');
        $view->registerJs($js, View::POS_READY);

        if ($this->autoDetectId !== false) {

            $js = new JsExpression('
                $("' . $this->autoDetectId . '").on("keyup", function(e) {
                    var wrapper = $("#' . $this->id . '-slug");
                    var slug = e.target.value.toSlug(false);
                    if (slug == "") {
                        wrapper.hide();
                    } else {
                        $("' . $this->_slugElement . '").val(slug);
                        wrapper.find(".raw-slug").html(slug);
                        wrapper.show();
                    }
                });
            ');
            $view->registerJs($js, View::POS_READY);
        }

        echo Html::endTag('div');
    }
}