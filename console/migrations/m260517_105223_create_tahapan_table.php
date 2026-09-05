<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tahapan}}`.
 */
class m260517_105223_create_tahapan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tahapan}}', [
            'id' => $this->primaryKey(),
            'judul_tahapan' => $this->string(255)->notNull(),
            'tahun' => $this->integer()->notNull(),
            'created_at' => $this->integer()->null(),
            'updated_at' => $this->integer()->null(),
        ]);

        $this->createTable('{{%tahapan_item}}', [
            'id' => $this->primaryKey(),
            'tahapan_id' => $this->integer()->notNull(),
            'nama_tahapan' => $this->string(255)->notNull(),
            'urutan' => $this->integer()->defaultValue(0),
            'icon_gambar' => $this->string(255)->null(),
            'tanggal' => $this->date()->null(),
            'dokumen' => $this->string(255)->null(),
        ]);

        $this->addForeignKey('fk-tahapan_item-tahapan_id', '{{%tahapan_item}}', 'tahapan_id', '{{%tahapan}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-tahapan_item-tahapan_id', '{{%tahapan_item}}');
        $this->dropTable('{{%tahapan_item}}');
        $this->dropTable('{{%tahapan}}');
    }
}
