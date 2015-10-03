<?php

namespace backend\controllers;

use Yii;
use common\models\Module;
use backend\components\Controller;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ModuleController implements the CRUD actions for Module model.
 */
class ModuleController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Module models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modules = Yii::$app->manager->modules['installed'];
        return $this->render('installed', [
            'modules' => $modules,
        ]);
    }

    public function actionInstalled()
    {
        $modules = Yii::$app->manager->modules['installed'];
        //$modules = array_slice($modules, 0, 10);
        return $this->render('installed', [
            'modules' => $modules,
        ]);
    }

    public function actionMarketplace()
    {
        $modules = Yii::$app->manager->modules['marketplace'];
        return $this->render('marketplace', [
            'modules' => $modules,
        ]);
    }

    public function actionAvailableUpdates()
    {
        $modules = Yii::$app->manager->modules['available-updates'];
        return $this->render('available-updates', [
            'modules' => $modules,
        ]);
    }

    public function actionChangeStatus()
    {
        if (Yii::$app->request->isAjax) {
            $params = [
                'id' => Yii::$app->request->post('id', false),
                'status' => Yii::$app->request->post('status', false)
            ];
            if ($params['id'] !== false && $params['status'] !== false) {
                $modules = Yii::$app->manager->modules['installed'];
                if (isset($modules[$params['id']])) {
                    if ($params['status'] == 'active') {
                        return $modules[$params['id']]->disable();
                    } else if ($params['status'] == 'inactive') {
                        return $modules[$params['id']]->enable();
                    } else if ($params['status'] == 'uninstall') {
                        return $modules[$params['id']]->uninstall();
                    }
                }
            }
        }
    }
}
