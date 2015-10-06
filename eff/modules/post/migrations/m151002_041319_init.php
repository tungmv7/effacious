<?php

use yii\db\Schema;
use yii\db\Migration;

class m151002_041319_init extends Migration
{
    public function up()
    {
        $tableOptions = '';
        $this->createTable('post', [
            'id' => $this->bigPrimaryKey(11)->unique(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(255)->notNull(),
            'type' => $this->string(255)->notNull(),
            'visibility' => $this->string(255)->notNull(),
            'title' => $this->string(255),
            'excerpt' => $this->string(255),
            'body' => $this->text(),
            'creator' => $this->string(255),
            'slug' => $this->string(255),
            'published_at' => $this->integer(11),
            'featured_image' => $this->string(255),
            'password' => $this->string(255),
            'meta_data' => $this->text(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'note' => $this->text(),
            'created_by' => $this->integer(11),
            'created_at' => $this->integer(11),
            'updated_by' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'version' => $this->bigInteger(11)->defaultValue(0)->notNull(),
            'is_deleted' => $this->boolean()->notNull()->defaultValue(false),
            'deleted_at' => $this->string(255)
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('post');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
