<?php

use yii\db\Migration;

/**
 * Class m221022_140452_add_column_image_in_table_post
 */
class m221022_140452_add_column_image_in_table_post extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{posts}}', 'image', $this->string());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{posts}}', 'image');
    }
}
