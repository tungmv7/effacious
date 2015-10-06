<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 4:15 PM
 */

namespace eff\actions;

class Action extends \yii\base\Action
{
    public $modelClass;
    public $modelSearchClass;
    public $redirect;
    public $view;

    protected function getModelClass()
    {
        if ($this->modelClass !== null) {
            return $this->modelClass;
        } else if ($this->controller->modelClass !== null) {
            return $this->controller->modelClass;
        } else {
            throw new InvalidConfigException('The modelClass param is required.');
        }
    }

    protected function getModelSearchClass()
    {
        if ($this->modelSearchClass !== null) {
            return $this->modelSearchClass;
        } else if ($this->controller->modelSearchClass !== null) {
            return $this->controller->modelSearchClass;
        } else {
            throw new InvalidConfigException('The modelSearchClass param is required.');
        }
    }

}