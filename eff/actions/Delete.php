<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 4:23 PM
 */

namespace eff\actions;


class Delete extends Action
{
    // view file
    public $view = 'index';

    // model class
    public $modelClass;

    public function run($id)
    {
        // get model class
        if ($this->modelClass !== null) {
            $modelClass = $this->modelClass;
        } else if ($this->controller->modelClass !== null) {
            $modelClass = $this->controller->modelClass;
        } else {
            throw new InvalidConfigException('The modelClass param is required.');
        }

        // find model data
        $modelClass::findOne($id)->delete();

        // render to view
        return $this->controller->render($this->view);

    }

}