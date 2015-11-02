<?php

namespace eff\modules\tree\models;

use eff\modules\tree\behaviors\TreeBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "tree".
 *
 * @property integer $id
 * @property integer $tree
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 * @property string $name
 * @property string $icon
 * @property string $url
 * @property string $title
 * @property string $description
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $version
 * @property integer $is_deleted
 * @property string $deleted_at
 */
class Tree extends \eff\components\ActiveRecord
{
    public function behaviors() {
        return [
            'tree' => [
                'class' => TreeBehavior::className(),
                'treeAttribute' => 'tree'
            ],
            BlameableBehavior::className(),
            TimestampBehavior::className(),
        ];
    }

    public function optimisticLock()
    {
        return 'version';
    }

//    public function transactions()
//    {
//        return [
//            self::SCENARIO_DEFAULT => self::OP_ALL,
//        ];
//    }

    public static function find()
    {
        return new TreeQuery(get_called_class());
    }


        /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tree';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tree', 'name'], 'required'],
            [['lft', 'rgt', 'depth', 'created_by', 'created_at', 'updated_by', 'updated_at', 'version', 'is_deleted'], 'integer'],
            [['tree', 'name', 'icon', 'url', 'title', 'description', 'deleted_at'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('file', 'ID'),
            'tree' => Yii::t('file', 'Tree'),
            'lft' => Yii::t('file', 'Lft'),
            'rgt' => Yii::t('file', 'Rgt'),
            'depth' => Yii::t('file', 'Depth'),
            'name' => Yii::t('file', 'Name'),
            'icon' => Yii::t('file', 'Icon'),
            'url' => Yii::t('file', 'Url'),
            'title' => Yii::t('file', 'Title'),
            'description' => Yii::t('file', 'Description'),
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
