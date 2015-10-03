<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 9/26/15
 * Time: 10:51 PM
 */

namespace backend\components;


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
}