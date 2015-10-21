<?php

namespace eff\modules\file\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "file".
 *
 * @property integer $id
 * @property string $name
 * @property string $filename
 * @property string $path
 * @property string $url
 * @property string $type
 * @property string $extension
 * @property string $storage
 * @property string $thumbnail
 * @property string $description
 * @property string $meta_data
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $version
 * @property integer $is_deleted
 * @property string $deleted_at
 */
class File extends \eff\components\ActiveRecord
{

    public function loadDefaultValues()
    {
        parent::loadDefaultValues();

        $this->storage = 'default';
    }

    public function optimisticLock()
    {
        return 'version';
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            BlameableBehavior::className(),
            TimestampBehavior::className()
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'filename', 'path', 'url', 'type', 'extension', 'storage'], 'required'],
            [['meta_data'], 'string'],
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'version', 'is_deleted'], 'integer'],
            [['name', 'filename', 'path', 'url', 'type', 'extension', 'storage', 'thumbnail', 'description', 'deleted_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('post', 'ID'),
            'name' => Yii::t('post', 'Name'),
            'filename' => Yii::t('post', 'Filename'),
            'path' => Yii::t('post', 'Path'),
            'url' => Yii::t('post', 'Url'),
            'type' => Yii::t('post', 'Type'),
            'extension' => Yii::t('post', 'Extension'),
            'storage' => Yii::t('post', 'Storage'),
            'thumbnail' => Yii::t('post', 'Thumbnail'),
            'description' => Yii::t('post', 'Description'),
            'meta_data' => Yii::t('post', 'Meta Data'),
            'created_by' => Yii::t('post', 'Created By'),
            'created_at' => Yii::t('post', 'Created At'),
            'updated_by' => Yii::t('post', 'Updated By'),
            'updated_at' => Yii::t('post', 'Updated At'),
            'version' => Yii::t('post', 'Version'),
            'is_deleted' => Yii::t('post', 'Is Deleted'),
            'deleted_at' => Yii::t('post', 'Deleted At'),
        ];
    }
}
