<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/6/15
 * Time: 4:15 PM
 */

namespace eff\actions;

use Yii;

class Index extends Action
{
    public $view = 'index';

    public function run()
    {
        // get model class
        $modelSearchClass = $this->getModelSearchClass();

        // query to db
        $searchModel = new $modelSearchClass();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // render to view
        return $this->controller->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}