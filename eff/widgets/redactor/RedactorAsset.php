<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace eff\widgets\redactor;

/**
 * @author Nghia Nguyen <yiidevelop@hotmail.com>
 * @since 2.0
 */
class RedactorAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@eff/widgets/redactor/assets';

    public $css = [
        'redactor.min.css',
        'custom.css'
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $js = [
        'redactor.min.js',
    ];

}