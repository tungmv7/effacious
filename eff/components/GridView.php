<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/8/15
 * Time: 10:50 AM
 */

namespace eff\components;

use yii\web\JsExpression;
use yii\web\View;

class GridView extends \yii\grid\GridView
{

    public $tableOptions = ['class' => 'table table-hover'];

    public $layout = "{items}";

    public function run()
    {
        parent::run();

//        $view = $this->getView();
//        $view->registerJs(new JsExpression('
//            $("#'.$this->options['id'].' table").DataTable();
//        '), View::POS_READY);
    }

}