<?php

use yii\db\Migration;

/**
 * Class m190722_134427_add_new_attacgment_fields
 */
class m190722_134427_add_new_attacgment_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%task}}', 'attachment_extension', $this->string(10)->defaultValue(null)->after('attachment'));
        $this->addColumn('{{%task}}', 'attachment_mime_type', $this->string(100)->defaultValue(null)->after('attachment_extension'));
        $this->addColumn('{{%task}}', 'attachment_size', $this->integer(10)->unsigned()->defaultValue(null)->after('attachment_mime_type'));
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%task}}', 'attachment_extension');
        $this->dropColumn('{{%task}}', 'attachment_mime_type');
        $this->dropColumn('{{%task}}', 'attachment_size');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190722_134427_add_new_attacgment_fields cannot be reverted.\n";

        return false;
    }
    */
}
