<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 9/26/15
 * Time: 11:07 PM
 */

namespace backend\components;

use Yii;
use yii\helpers\Json;
use yii\base\BootstrapInterface;

class ModuleAutoLoader implements  BootstrapInterface
{

    public $cacheDuration = 3600;
    const CACHE_KEY = 'backend:modules:configuration';
    const LIMIT = 50;

    public function bootstrap($app)
    {
        $moduleConfigurations = Yii::$app->cache->get(self::CACHE_KEY);

        if ($moduleConfigurations === false) {

            $installedModules = [];
            $installedCount = 0;
            foreach (\Yii::$app->params['modulesPath'] as $alias) {
                $modulePath = \Yii::getAlias($alias);
                $modules = glob($modulePath . DIRECTORY_SEPARATOR . '*' . DIRECTORY_SEPARATOR . 'module.json');
                natsort($modules);
                foreach ($modules as $jsonFile) {
                    $installedModules[] = Json::decode(file_get_contents($jsonFile));
                    $installedCount++;
                    if ($installedCount > self::LIMIT) {
                        break;
                    }
                }
            }
            $moduleConfigurations['installed'] = $installedModules;
        }

        Yii::$app->manager->registerModules($moduleConfigurations['installed'], 'installed');
        Yii::$app->manager->registerModules([], 'marketplace');
        Yii::$app->manager->registerModules([], 'available-updates');
    }
}