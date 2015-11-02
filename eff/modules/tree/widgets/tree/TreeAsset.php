<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/29/15
 * Time: 4:29 PM
 */

namespace eff\modules\tree\widgets\tree;

use yii\web\AssetBundle;

class TreeAsset extends AssetBundle
{
    public $sourcePath = '@eff/modules/tree/widgets/tree/assets';
    public $depends = [
        'yii\web\JqueryAsset',
    ];
    public $js = [
        'jstree.min.js'
    ];
    public $css = [
        'themes/default/style.min.css'
    ];
}