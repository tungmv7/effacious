<?php

use yii\db\Schema;
use yii\db\Migration;

class m151029_074039_init extends Migration
{
    public function up()
    {
        $tableOptions = '';
        $this->createTable('tree', [
            'id' => $this->bigPrimaryKey(11)->unique(),
            'tree' => $this->string(255)->notNull(),
            'lft' => $this->integer(11)->notNull(),
            'rgt' => $this->integer(11)->notNull(),
            'depth' => $this->integer(11)->notNull(),
            'name' => $this->string(255)->notNull(),
            'icon' => $this->string(255),
            'url' => $this->string(255),
            'title' => $this->string(255),
            'description' => $this->string(255),
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
        return $this->dropTable('tree');
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
