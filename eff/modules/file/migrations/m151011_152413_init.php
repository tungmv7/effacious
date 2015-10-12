<?php

use yii\db\Schema;
use yii\db\Migration;

class m151011_152413_init extends Migration
{
    public function up()
    {
        $tableOptions = '';
        $this->createTable('file', [
            'id' => $this->bigPrimaryKey(11)->unique(),
            'name' => $this->string(255)->notNull(),
            'base_path' => $this->string(255)->notNull(),
            'base_url' => $this->string(255)->notNull(),
            'file_type' => $this->string(255)->notNull(),
            'storage' => $this->string(255)->notNull(),
            'thumbnail' => $this->string(255),
            'title' => $this->string(255)->notNull(),
            'description' => $this->string(255),
            'meta_data' => $this->text(),
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
        $this->dropTable('file');
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
