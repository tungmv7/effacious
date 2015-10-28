<?php

namespace eff\widgets\cropper;
use yii\web\AssetBundle;

/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/28/15
 * Time: 9:19 AM
 */
class CropperAsset extends AssetBundle
{
    public $sourcePath = '@eff/widgets/cropper/assets';

    public $css = [
        'cropper.min.css'
    ];
    public $js = [
        'cropper.min.js'
    ];
}