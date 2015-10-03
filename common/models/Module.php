<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%module}}".
 *
 * @property integer $id
 * @property string $unique_id
 * @property integer $is_core
 * @property string $status
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 */
class Module extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%module}}';
    }

//    public function behaviors()
//    {
//        return [
//            [
//                'class' => BlameableBehavior::className(),
//                'value' => function(){return 1;} // sample
//            ],
//            [
//                'class' => TimestampBehavior::className()
//            ]
//        ];
//    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['unique_id', 'is_core', 'status'], 'required'],
            [['created_by', 'created_at', 'updated_by', 'updated_at'], 'integer'],
            [['is_core'], 'boolean'],
            [['unique_id', 'status'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('module', 'ID'),
            'unique_id' => Yii::t('module', 'Unique ID'),
            'is_core' => Yii::t('module', 'Is Core'),
            'status' => Yii::t('module', 'Status'),
            'created_by' => Yii::t('module', 'Created By'),
            'created_at' => Yii::t('module', 'Created At'),
            'updated_by' => Yii::t('module', 'Updated By'),
            'updated_at' => Yii::t('module', 'Updated At'),
        ];
    }
}
