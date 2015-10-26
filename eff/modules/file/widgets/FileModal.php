<?php

namespace eff\modules\file\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;

/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/18/15
 * Time: 3:02 PM
 */
class FileModal extends \yii\bootstrap\Modal
{
    public $bodyOptions = ['class' => 'modal-body'];
    public $headerOptions = ['style' => 'border-bottom: 0;'];
    public $options = ['class' => 'files-modal'];

    public $embedView = "@eff/modules/file/views/admin/embed";
    public $embedParams = [];

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (!isset($this->embedParams['isMultiple'])) {
            $this->embedParams['isMultiple'] = true;
        }
        if (!isset($this->embedParams['withLibrary'])) {
            $this->embedParams['withLibrary'] = true;
        }
        if (!isset($this->embedParams['withFromLink'])) {
            $this->embedParams['withFromLink'] = true;
        }
        if (!isset($this->embedParams['acceptedFiles'])) {
            $this->embedParams['acceptedFiles'] = ['image/*', 'video/*', 'audio/*', '.doc', '.xls', '.pdf'];
        }

        if (!isset($this->embedParams['dataProvider']) && $this->embedParams['withLibrary']) {
            $searchModelClass = new \eff\modules\file\models\FileSearch();

            $params = Yii::$app->request->queryParams;
            $acceptedFiles = (array) $this->embedParams['acceptedFiles'];
            foreach($acceptedFiles as $temp) {
                if (strpos($temp, '.') === 0) {
                    $params["FileSearch"]["extension"][] = substr($temp, 1);
                } else {
                    $params["FileSearch"]["type"][] = substr($temp, 0, strlen($temp) - 1) . '%';
                }
            }
            $this->embedParams['dataProvider'] = $searchModelClass->search($params);
        }
        if (!isset($this->embedParams['objectHandlerFunctions'])) {
            $this->embedParams['objectHandlerFunctions'] = uniqid("fileHandler");
        }
        $this->options['data-unique-id'] = Inflector::slug($this->id, '');
        $this->options['data-handler'] = $this->embedParams['objectHandlerFunctions'];
        $this->initOptions();
        echo $this->renderToggleButton() . "\n";
        echo Html::beginTag('div', $this->options) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-dialog ' . $this->size]) . "\n";
        echo Html::beginTag('div', ['class' => 'modal-content']) . "\n";
        echo $this->renderHeader() . "\n";
        echo $this->renderBodyBegin() . "\n";

    }

    public function run()
    {
        $this->embedParams['modal'] = $this->id;
        echo "\n" . $this->render($this->embedView, $this->embedParams);
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');

        $this->registerPlugin('modal');
    }

    protected function renderBodyBegin()
    {
        return Html::beginTag('div', $this->bodyOptions);
    }
}