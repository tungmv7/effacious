<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/7/15
 * Time: 2:24 PM
 */

namespace eff\widgets\datetimepicker;

use Yii;
use yii\helpers\Html;
use yii\helpers\Json;

class DateTimePickerWidget extends \yii\widgets\InputWidget
{
    public $clientOptions = [
        'locale' => 'en',
    ];

    public $withTrigger = true;
    public $withTriggerIcon = 'glyphicon glyphicon-calendar';

    public $wrapperId;

    public $options = ['class' => 'form-control'];

    public function init()
    {
        parent::init();
        $this->wrapperId = 'wrapper-datetimepicker-' . $this->id;
    }

    public function run()
    {
        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }

        if ($this->withTrigger) {
            echo Html::beginTag('div', ['class' => 'input-group date', 'id' => $this->wrapperId]);
            echo $input . Html::tag('span', Html::tag('span', '', ['class' => $this->withTriggerIcon]), ['class' => 'input-group-addon']);
            echo Html::endTag('div');
        } else {
            echo $input;
        }

        $this->registerPlugin();
    }

    /**
     * Registers CKEditor plugin
     */
    protected function registerPlugin()
    {
        $view = $this->getView();

        DateTimePickerAssets::register($view);

        $id = $this->withTrigger ? $this->wrapperId : $this->options['id'];

        $options = $this->clientOptions !== false && !empty($this->clientOptions)
            ? Json::encode($this->clientOptions)
            : '{}';

        $js = "$('#$id').datetimepicker($options);";
        $view->registerJs($js, \yii\web\View::POS_READY);
    }
}