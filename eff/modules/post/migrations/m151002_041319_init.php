<?php

use yii\db\Schema;
use yii\db\Migration;

class m151002_041319_init extends Migration
{
    public function up()
    {
        $tableOptions = '';
        $this->createTable('post', [
            'id' => $this->primaryKey(11)->unique(),
            'name' => $this->string(255)->notNull(),
            'title' => $this->string(255)->notNull(),
            'excerpt' => $this->string(255),
            'body' => $this->text(),
            'creator' => $this->string(255)->notNull(),
            'status' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'published_at' => $this->integer(11)->notNull(),
            'featured_image' => $this->integer(11),
            'type' => $this->string(255)->notNull(),
            'visibility' => $this->string(255)->notNull(),
            'password' => $this->string(255)->notNull(),
            'meta_data' => $this->text(),
            'seo_title' => $this->string(255),
            'seo_description' => $this->string(255),
            'seo_keywords' => $this->string(255),
            'note' => $this->text(),
            'created_by' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull()
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
