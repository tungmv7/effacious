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
        parent::init();
        $this->defaultOptions();
        $this->registerAssetBundle();
        $this->registerPlugins();
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

    protected function registerPlugins()
    {
        if (isset($this->clientOptions['plugins']) && count($this->clientOptions['plugins'])) {
            foreach ($this->clientOptions['plugins'] as $plugin) {
                $sourcePath = $this->getSourcePath();
                $js = 'plugins/' . $plugin . '/' . $plugin . '.js';
                if (file_exists($sourcePath . DIRECTORY_SEPARATOR . $js)) {
                    $this->assetBundle->js[] = $js;
                }
                $css = 'plugins/' . $plugin . '/' . $plugin . '.css';
                if (file_exists($sourcePath . DIRECTORY_SEPARATOR . $css)) {
                    $this->assetBundle->css[] = $css;
                }
            }
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

    /**
     * @return AssetBundle
     */
    public function getAssetBundle()
    {
        if (!($this->_assetBundle instanceof AssetBundle)) {
            $this->registerAssetBundle();
        }
        return $this->_assetBundle;
    }
    /**
     * @return bool|string The path of assetBundle
     */
    public function getSourcePath()
    {
        return Yii::getAlias($this->getAssetBundle()->sourcePath);
    }
}
