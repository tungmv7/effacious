<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/7/15
 * Time: 2:25 PM
 */
namespace eff\widgets\datetimepicker;

class DateTimePickerAssets extends \yii\web\AssetBundle
{
    public $sourcePath = '@eff/widgets/datetimepicker/assets';

    public $css = [
        'css/bootstrap-datetimepicker.min.css',
    ];
    public $depends = [
        '\yii\bootstrap\BootstrapAsset'
    ];
    public $js = [
        'js/moment-with-locales.js',
        'js/bootstrap-datetimepicker.min.js',
    ];
}