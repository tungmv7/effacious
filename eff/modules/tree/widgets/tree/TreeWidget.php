<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/29/15
 * Time: 4:28 PM
 */

namespace eff\modules\tree\widgets\tree;


use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

class TreeWidget extends InputWidget
{
    public $clientOptions = [];

    public function init()
    {
        parent::init();
        echo Html::beginTag('div', ['id' => $this->options['id']]);
    }

    public function run()
    {
        echo Html::endTag('div');
        $this->registerPlugin();
    }

    protected function registerPlugin()
    {
        $view = $this->getView();

        TreeAsset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        $js = "$('#$id').jstree($options);";
        $view->registerJs($js, \yii\web\View::POS_READY);
    }
}