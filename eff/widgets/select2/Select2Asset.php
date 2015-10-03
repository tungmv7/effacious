<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2widgets\select2;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * Asset bundle for the Select Asset
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Select2Asset extends AssetBundle
{
	public function init()
    {
        $this->sourcePath= __DIR__ . '/assets';        
        parent::init();
    }

	public $baseUrl = '@web';
	public $js = [
		'select2.js',
	];
	public $depends = [
		'yii\web\JqueryAsset',
	];
	public $jsOptions = [
    	'position' => View::POS_END
	];
}
