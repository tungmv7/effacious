<?php

namespace eff\widgets\cropper;

use yii\widgets\InputWidget;

/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/28/15
 * Time: 9:19 AM
 */
class Cropper extends InputWidget
{
    public $clientOptions = [];

    public function run()
    {

    }

    protected function registerPlugin()
    {
        $view = $this->getView();

        CropperAsset::register($view);

        $id = $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        $js = "$('#$id > img').cropper($options);";
        $view->registerJs($js, \yii\web\View::POS_READY);
    }

}