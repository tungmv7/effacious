<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 11:19 AM
 */

namespace eff\components;


use eff\actions\Create;
use eff\actions\Delete;
use eff\actions\Index;
use eff\actions\Update;
use eff\actions\View;

class Controller extends \yii\web\Controller
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->view->params['menu'] = [
            ['label' => \Yii::t('admin', 'Manage Modules'), 'url' => ['/module']],
            ['label' => \Yii::t('admin', 'Manage Posts'), 'url' => ['/post']],
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => Index::className()
            ],
            'view' => [
                'class' => View::className()
            ],
            'create' => [
                'class' => Create::className()
            ],
            'update' => [
                'class' => Update::className()
            ],
            'delete' => [
                'class' => Delete::className()
            ]
        ];
    }

}