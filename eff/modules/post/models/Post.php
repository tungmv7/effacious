<?php

namespace eff\modules\post\models;

use eff\components\ActiveRecord;
use Yii;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property string $excerpt
 * @property string $body
 * @property string $creator
 * @property string $status
 * @property string $slug
 * @property integer $published_at
 * @property integer $featured_image
 * @property string $type
 * @property string $visibility
 * @property string $password
 * @property string $meta_data
 * @property string $seo_title
 * @property string $seo_description
 * @property string $seo_keywords
 * @property string $note
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_by
 * @property integer $updated_at
 * @property integer $version
 */
class Post extends \eff\components\ActiveRecord
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_PENDING = 'pending';
    const STATUS_DRAFT = 'draft';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%post}}';
    }

    public function optimisticLock()
    {
        return 'version';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(), [
                BlameableBehavior::className(),
                TimestampBehavior::className(),
                [
                    'class' => SluggableBehavior::className(),
                    'attribute' => 'title'
                ]
            ]
        );
    }

    const SAVE_OPTION_PUBLISH_IMMEDIATELY = 'publish_immediately';
    const SAVE_OPTION_PUBLISH_SCHEDULED = 'publish_scheduled';
    const SAVE_OPTION_PENDING_REVIEW = 'pending_review';
    const SAVE_OPTION_DRAFT = 'draft';

    public static function getSaveOptions()
    {
        return [
            self::SAVE_OPTION_PUBLISH_IMMEDIATELY => 'Publish Immediately',
            self::SAVE_OPTION_PENDING_REVIEW => 'Pending Review',
            self::SAVE_OPTION_PUBLISH_SCHEDULED => 'Publish Scheduled',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(), [
                [['name', 'title', 'creator', 'status', 'slug', 'published_at', 'type', 'visibility'], 'required'],
                [['body', 'meta_data', 'note'], 'string'],
                [['published_at', 'featured_image', 'created_by', 'created_at', 'updated_by', 'updated_at', 'version'], 'integer'],
                [['name', 'title', 'excerpt', 'creator', 'status', 'slug', 'type', 'visibility', 'password', 'seo_title', 'seo_description', 'seo_keywords'], 'string', 'max' => 255]
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('post', 'ID'),
            'name' => Yii::t('post', 'Name'),
            'title' => Yii::t('post', 'Title'),
            'excerpt' => Yii::t('post', 'Excerpt'),
            'body' => Yii::t('post', 'Body'),
            'creator' => Yii::t('post', 'Creator'),
            'status' => Yii::t('post', 'Status'),
            'slug' => Yii::t('post', 'Slug'),
            'published_at' => Yii::t('post', 'Published At'),
            'featured_image' => Yii::t('post', 'Featured Image'),
            'type' => Yii::t('post', 'Type'),
            'visibility' => Yii::t('post', 'Visibility'),
            'password' => Yii::t('post', 'Password'),
            'meta_data' => Yii::t('post', 'Meta Data'),
            'seo_title' => Yii::t('post', 'Seo Title'),
            'seo_description' => Yii::t('post', 'Seo Description'),
            'seo_keywords' => Yii::t('post', 'Seo Keywords'),
            'note' => Yii::t('post', 'Note'),
            'created_by' => Yii::t('post', 'Created By'),
            'created_at' => Yii::t('post', 'Created At'),
            'updated_by' => Yii::t('post', 'Updated By'),
            'updated_at' => Yii::t('post', 'Updated At'),
            'version' => Yii::t('post', 'Version'),
        ];
    }
}
