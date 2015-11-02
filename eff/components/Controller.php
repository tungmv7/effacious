<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 10/2/15
 * Time: 11:19 AM
 */

namespace eff\components;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class Controller extends \yii\web\Controller
{

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function init()
    {
        $layout = \Yii::$app->request->get('layout');
        if (!empty($layout)) {
            $this->layout = '/'. $layout; // default layout on app layout dir
            $this->view->params['layout'] = $layout;
        }

        $this->view->params['menu'] = [
            ['label' => \Yii::t('admin', 'Manage Modules'), 'url' => ['/module']],
            ['label' => \Yii::t('admin', 'Manage Posts'), 'url' => ['/post']],
            ['label' => \Yii::t('admin', 'Manage Files'), 'url' => ['/file']],
            ['label' => \Yii::t('admin', 'Manage Tree'), 'url' => ['/tree']],
        ];
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'delete' => ['post']
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'index' => [
                'class' => \eff\actions\Index::className()
            ],
            'view' => [
                'class' => \eff\actions\View::className()
            ],
            'create' => [
                'class' => \eff\actions\Create::className()
            ],
            'update' => [
                'class' => \eff\actions\Update::className()
            ],
            'delete' => [
                'class' => \eff\actions\Delete::className()
            ]
        ];
    }

}