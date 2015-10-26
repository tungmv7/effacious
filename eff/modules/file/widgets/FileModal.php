<?php

namespace eff\modules\file\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\Inflector;

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
    public $params = [];

    public function init()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        if (!isset($this->params['isMultiple'])) {
            $this->params['isMultiple'] = true;
        }
        if (!isset($this->params['withLibrary'])) {
            $this->params['withLibrary'] = true;
        }
        if (!isset($this->params['withFromLink'])) {
            $this->params['withFromLink'] = false;
        }
        if (!isset($this->params['acceptedFiles'])) {
            $this->params['acceptedFiles'] = 'image/*,video/*,audio/*,.doc,.xls,.pdf,.zip';
        }
        $this->params['objectHandlerFunctions'] = Inflector::slug($this->id . '-handler', '');

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
        $this->params['modal'] = $this->id . '-embed';
        echo "\n" . $this->render($this->embedView, $this->params);
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