<?php

namespace eff\widgets\dropzone;

use yii\web\AssetBundle;

class DropZoneAsset extends AssetBundle
{
    public $sourcePath = '@eff/widgets/dropzone/assets';
    public $css = [
        'dropzone.min.css',
        'custom.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
//        'yii\jui\JuiAsset',
    ];
    public $js = [
        'dropzone.min.js',
    ];
}
