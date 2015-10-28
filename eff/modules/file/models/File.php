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
 * @property string $path
 * @property string $url
 * @property string $type
 * @property string $extension
 * @property string $storage
 * @property string $thumbnail
 * @property string $origin
 * @property string $title
 * @property string $alt
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
            [['name', 'path', 'url', 'type', 'extension', 'storage', 'origin', 'title'], 'required'],
            [['meta_data'], 'string'],
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'version', 'is_deleted'], 'integer'],
            [['name', 'path', 'url', 'type', 'storage', 'thumbnail', 'origin', 'title', 'alt', 'description', 'deleted_at'], 'string', 'max' => 255],
            [['extension'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('file', 'ID'),
            'name' => Yii::t('file', 'Name'),
            'path' => Yii::t('file', 'Path'),
            'url' => Yii::t('file', 'Url'),
            'type' => Yii::t('file', 'Type'),
            'extension' => Yii::t('file', 'Extension'),
            'storage' => Yii::t('file', 'Storage'),
            'thumbnail' => Yii::t('file', 'Thumbnail'),
            'origin' => Yii::t('file', 'Origin'),
            'title' => Yii::t('file', 'Title'),
            'alt' => Yii::t('file', 'Alt'),
            'description' => Yii::t('file', 'Description'),
            'meta_data' => Yii::t('file', 'Meta Data'),
            'created_by' => Yii::t('file', 'Created By'),
            'created_at' => Yii::t('file', 'Created At'),
            'updated_by' => Yii::t('file', 'Updated By'),
            'updated_at' => Yii::t('file', 'Updated At'),
            'version' => Yii::t('file', 'Version'),
            'is_deleted' => Yii::t('file', 'Is Deleted'),
            'deleted_at' => Yii::t('file', 'Deleted At'),
        ];
    }
}
