<?php

namespace eff\modules\file\models;

use Yii;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $base_path
 * @property string $base_url
 * @property string $file_type
 * @property string $storage
 * @property string $thumbnail
 * @property string $title
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
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'base_path', 'base_url', 'file_type', 'storage', 'title'], 'required'],
            [['meta_data'], 'string'],
            [['created_by', 'created_at', 'updated_by', 'updated_at', 'version', 'is_deleted'], 'integer'],
            [['name', 'base_path', 'base_url', 'file_type', 'storage', 'thumbnail', 'title', 'description', 'deleted_at'], 'string', 'max' => 255]
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
            'base_path' => Yii::t('post', 'Base Path'),
            'base_url' => Yii::t('post', 'Base Url'),
            'file_type' => Yii::t('post', 'File Type'),
            'storage' => Yii::t('post', 'Storage'),
            'thumbnail' => Yii::t('post', 'Thumbnail'),
            'title' => Yii::t('post', 'Title'),
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
