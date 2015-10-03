<?php

use yii\db\Schema;
use yii\db\Migration;

class m150926_162250_module extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->dropTable('{{%module}}');
        $this->createTable('module', [
            'id' => $this->primaryKey(11),
            'unique_id' => $this->string(255)->notNull(),
            'is_core' => $this->boolean()->notNull(),
            'status' => $this->string(255)->notNull(),
            'created_by' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_by' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%module}}');
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
