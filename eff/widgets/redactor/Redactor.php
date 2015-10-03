<?php
namespace eff\widgets\redactor;

use Yii;
use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;

class Redactor extends InputWidget
{
    public $options = [];
    public $clientOptions = [];
    private $_assetBundle;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->defaultOptions();
        $this->registerAssetBundle();
        $this->registerScript();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        if ($this->hasModel()) {
            echo Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            echo Html::textarea($this->name, $this->value, $this->options);
        }
    }

    /**
     * Sets default options
     */
    protected function defaultOptions()
    {
        if (!isset($this->options['id'])) {
            if ($this->hasModel()) {
                $this->options['id'] = Html::getInputId($this->model, $this->attribute);
            } else {
                $this->options['id'] = $this->getId();
            }
        }
        Html::addCssClass($this->options, 'form-control');
    }

    /**
     * Register clients script to View
     */
    protected function registerScript()
    {
        $clientOptions = (count($this->clientOptions)) ? Json::encode($this->clientOptions) : '';
        $this->getView()->registerJs("jQuery('#{$this->options['id']}').redactor({$clientOptions});");
    }

    /**
     * Register assetBundle
     */
    protected function registerAssetBundle()
    {
        $this->_assetBundle = RedactorAsset::register($this->getView());
    }

}
