<?php

use yii\db\Migration;

/**
 * Class m260517_113736_alter_tanggal_column_in_tahapan_item
 */
class m260517_113736_alter_tanggal_column_in_tahapan_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%tahapan_item}}', 'tanggal', $this->string(255)->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%tahapan_item}}', 'tanggal', $this->date()->null());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m260517_113736_alter_tanggal_column_in_tahapan_item cannot be reverted.\n";

        return false;
    }
    */
}
