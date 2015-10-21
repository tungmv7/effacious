<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 4:27 PM
 */

namespace eff\actions;


class View extends Action
{
    // view file
    public $view = 'view';

    public function run($id)
    {
        // get model class
        $modelClass = $this->getModelClass();

        // find model data
        $model = $modelClass::findOne($id);

        // render to view
        return $this->controller->render($this->view, [
            'model' => $model,
        ]);

    }
}