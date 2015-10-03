<?php
/**
 * @link http://www.gxccms.com/
 * @copyright Copyright (c) 2014 GXC CMS
 * @license http://www.gxccms.com/license/yii2cms/
 */

namespace gxc\yii2widgets\select2;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use yii\web\View;

/**
 * Select2 Widget for the Input
 *
 * @author Tuan Nguyen <nganhtuan63@gmail.com>
 * @since 2.0
 */
class Select2 extends InputWidget
{

	public $mode='default'; //Default or Tags
	public $items=null;
	public $clientOptions=[];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();		
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		switch ($this->mode) {
			case 'tag':
				if ($this->hasModel()) {
					echo Html::activeHiddenInput($this->model, $this->attribute, $this->options);
				} else {
					echo Html::hiddenInput($this->name, $this->value, $this->options);
				}
				break;
			
			default:			
				if ($this->hasModel()) {
					echo Html::activeDropDownList($this->model, $this->attribute, $this->items, $this->options);
				} else {
					echo Html::dropDownList($this->name, $this->value, $this->items, $this->options);
				}
				break;
		}
		
		$this->registerPlugin();
	}

	/**
	 * Registers CKEditor plugin
	 */
	protected function registerPlugin()
	{
		$view = $this->getView();

		Select2Asset::register($view);

		$id = $this->options['id'];

		$options = $this->clientOptions !== false && !empty($this->clientOptions)
			? Json::encode($this->clientOptions)
			: '{}';

		$js = "$('#$id').select2($options);";
		$view->registerJs($js, View::POS_END);
	}
}
