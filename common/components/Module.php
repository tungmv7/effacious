<?php
/**
 * Created by PhpStorm.
 * User: tungmangvien
 * Date: 9/26/15
 * Time: 11:10 PM
 */

namespace common\components;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class Module extends \yii\base\Module
{
    private $_isActivated = false;
    private $_moduleInfo = null;

    const STATUS_ACTIVE = 'active';
    const STATUS_INACTIVE = 'inactive';

    public $defaultRoute = 'admin';

    /**
     * Get module description
     *
     * @return string
     */
    public function getDescription()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['description'])) {
            return $moduleInfo['description'];
        } else {
            return '';
        }
    }

    /**
     * Get module name
     *
     * @return string
     */
    public function getName()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['name'])) {
            return $moduleInfo['name'];
        } else {
            return '';
        }
    }

    /**
     * Get module icon
     *
     * @return array|string
     */
    public function getIcon()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['icon'])) {
            return Yii::$app->assetManager->publish($this->getBasePath() . DIRECTORY_SEPARATOR . $moduleInfo['icon']);
        } else {
            return 'data:image/png;base64,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';
        }
    }

    /**
     * Get module version
     *
     * @return string
     */
    public function getVersion()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['version'])) {
            return $moduleInfo['version'];
        } else {
            return '1.0.0';
        }
    }

    /**
     * Get module keywords
     *
     * @return array
     */
    public function getKeywords()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['keywords'])) {
            return $moduleInfo['keywords'];
        } else {
            return ['unknown'];
        }
    }

    /**
     * Get help information
     *
     * @return string
     */
    public function getHelp()
    {
        return 'This is help information';
    }

    /**
     * Check module is core module or not
     *
     * @return bool
     */
    public function isCore()
    {
        $moduleInfo = $this->getModuleInfo();
        if (isset($moduleInfo['isCore'])) {
            return $moduleInfo['isCore'];
        } else {
            return false;
        }
    }

    /**
     * Check module is activated or not
     *
     * @return bool
     */
    public function isActivated()
    {
        return $this->_isActivated;
    }

    /**
     * Set module activated
     */
    public function setActivated()
    {
        $this->_isActivated = true;
    }

    public function install()
    {
        \Yii::$app->manager->registerModule();
    }

    /**
     * Perform enable module
     *
     * @return bool
     */
    public function enable()
    {
        if (!Yii::$app->hasModule($this->id)) {
            $module = \common\models\Module::findOne(['unique_id' => $this->id]);
            if ($module) {
                $module->status = self::STATUS_ACTIVE;
            } else {
                $module = new \common\models\Module();
                $module->unique_id = $this->id;
                $module->is_core = $this->isCore();
                $module->status = self::STATUS_ACTIVE;
            }

            if ($module->save()) {
                $this->migrate(self::STATUS_ACTIVE);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Perform disable module
     *
     * @return bool
     */
    public function disable()
    {
        if (!Yii::$app->hasModule($this->id)) {
            return false;
        }

        $module = \common\models\Module::findOne(['unique_id' => $this->id]);
        if ($module) {
            $module->status = self::STATUS_INACTIVE;
            if ($module->save()) {
                $this->migrate(self::STATUS_INACTIVE);
                return true;
            }
            return false;
        }
        return false;
    }

    /**
     * Uninstall module
     */
    public function uninstall()
    {
        // make sure this module is inactivated
        $this->disable();

        // get module path
        $modulePath = $this->getBasePath();

        // backup modules sources
        $backupPath = Yii::getAlias('@eff/backup_modules');
        FileHelper::copyDirectory($modulePath, $backupPath . DIRECTORY_SEPARATOR . $this->id);

        // remove current dir
        FileHelper::removeDirectory($modulePath, ['traverseSymlinks' => true]);
    }

    /**
     * Migrate database by module status
     *
     * @param $status
     */
    protected function migrate($status)
    {
        $migrationPath = $this->getBasePath() . DIRECTORY_SEPARATOR . 'migrations';
        if (is_dir($migrationPath)) {
            if ($status == self::STATUS_ACTIVE) {
                Migrate::web('up', $migrationPath);
            } else if ($status == self::STATUS_INACTIVE) {
                Migrate::web('down', $migrationPath);
            }
        }
    }

    /**
     * Set basic module information
     *
     * @param $moduleInfo
     */
    public function setModuleInfo($moduleInfo = false)
    {
        if ($moduleInfo !== false) {
            $this->_moduleInfo = $moduleInfo;
        } else {
            $this->_moduleInfo = $this->getModuleInfo();
        }
    }

    /**
     * Get module information from json file
     *
     * @return mixed|null
     */
    protected function getModuleInfo()
    {
        if (!empty($this->_moduleInfo)) {
            return $this->_moduleInfo;
        }

        $dataFromJson = file_get_contents($this->getBasePath() . DIRECTORY_SEPARATOR . 'module.json');
        return Json::decode($dataFromJson);
    }
}