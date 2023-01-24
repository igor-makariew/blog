<?php

use yii\db\Migration;

/**
 * Class m221023_090720_create_table_personal_data
 */
class m221023_090720_create_table_personal_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%personal_data}}', [
            'id' => $this->primaryKey(),
            'fio' => $this->string(64),
            'email' => $this->string(64),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%personal_data}}');
    }
}
