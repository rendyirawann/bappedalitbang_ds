<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%standar_pelayanan}}`.
 */
class m260713_090000_create_standar_pelayanan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%standar_pelayanan}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(255)->notNull(),
            'namaFile' => $this->string(255)->notNull(),
            'tahun' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%standar_pelayanan}}');
    }
}
