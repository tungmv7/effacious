<?php

namespace eff\modules\post\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string $name
 * @property string $status
 * @property string $type
 * @property string $visibility
 * @property string $title
 * @property string $excerpt
 * @property string $body
 * @property string $creator
 * @property string $slug
 * @property integer $published_at
 * @property string $featured_image
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
 * @property integer $is_deleted
 * @property string $deleted_at
 */
class Post extends \eff\components\ActiveRecord
{
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

    public function loadDefaultValues()
    {
        parent::loadDefaultValues();

        $this->status = self::STATUS_PUBLISHED;
        $this->published_at = time();
        $this->visibility = self::VISIBILITY_PUBLIC;
        $this->type = self::FORMAT_STANDARD;
        $this->creator = 'tung';
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
                    'attribute' => 'name',
                    'immutable' => true
                ]
            ]
        );
    }

    /**
     * Define post statuses
     */
    const STATUS_PUBLISHED = 'published';
    const STATUS_PENDING = 'pending';
    const STATUS_DRAFT = 'draft';
    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLISHED => Yii::t('post', 'Published'),
            self::STATUS_PENDING => Yii::t('post', 'Pending'),
            self::STATUS_DRAFT => Yii::t('post', 'Draft'),
            self::STATUS_REMOVED => Yii::t('post', 'Removed'),
        ];
    }

    /**
     * Define saving options
     */
    const SAVE_OPTION_PUBLISH_IMMEDIATELY = 'publish_immediately';
    const SAVE_OPTION_PUBLISH_SCHEDULED = 'publish_scheduled';
    const SAVE_OPTION_PENDING_REVIEW = 'pending_review';
    const SAVE_OPTION_DRAFT = 'draft';
    public static function getSaveOptions()
    {
        return [
            self::SAVE_OPTION_PUBLISH_IMMEDIATELY => Yii::t('post', 'Publish Immediately'),
            self::SAVE_OPTION_PENDING_REVIEW => Yii::t('post', 'Pending Review'),
            self::SAVE_OPTION_PUBLISH_SCHEDULED => Yii::t('post', 'Publish Scheduled')
        ];
    }

    /**
     * Define visibility types
     */
    const VISIBILITY_PUBLIC = 'public';
    const VISIBILITY_PRIVATE = 'private';
    public static function getVisibilityTypes()
    {
        return [
            self::VISIBILITY_PUBLIC => Yii::t('post', 'Public'),
            self::VISIBILITY_PRIVATE => Yii::t('post', 'Private')
        ];
    }

    /**
     * Define formatting types
     */
    const FORMAT_STANDARD = 'standard';
    const FORMAT_GALLERY = 'gallery';
    const FORMAT_LIVE = 'live';
    public static function getFormatTypes()
    {
        return [
            self::FORMAT_STANDARD => Yii::t('post', 'Standard'),
            self::FORMAT_GALLERY => Yii::t('post', 'Gallery'),
            self::FORMAT_LIVE => Yii::t('post', 'Live')
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status', 'type', 'visibility'], 'required'],
            [['body', 'meta_data', 'note'], 'string'],
            [['published_at', 'created_by', 'created_at', 'updated_by', 'updated_at', 'version', 'is_deleted'], 'integer'],
            [['name', 'status', 'type', 'visibility', 'title', 'excerpt', 'creator', 'slug', 'featured_image', 'password', 'seo_title', 'seo_description', 'seo_keywords', 'deleted_at'], 'string', 'max' => 255]
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
            'status' => Yii::t('post', 'Status'),
            'type' => Yii::t('post', 'Type'),
            'visibility' => Yii::t('post', 'Visibility'),
            'title' => Yii::t('post', 'Title'),
            'excerpt' => Yii::t('post', 'Excerpt'),
            'body' => Yii::t('post', 'Body'),
            'creator' => Yii::t('post', 'Creator'),
            'slug' => Yii::t('post', 'Slug'),
            'published_at' => Yii::t('post', 'Published At'),
            'featured_image' => Yii::t('post', 'Featured Image'),
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
            'is_deleted' => Yii::t('post', 'Is Deleted'),
            'deleted_at' => Yii::t('post', 'Deleted At'),
        ];
    }
}
