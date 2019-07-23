<?php

use yii\db\Migration;

/**
 * Class m190722_102232_add_new_created_by_field
 */
class m190722_102232_add_new_created_by_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
//        $this->addColumn('{{%project}}', 'created_by', $this->integer()->unsigned()->notNull()->after('duration'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        $this->dropColumn('{{%project}}', 'created_by');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190722_102232_add_new_created_by_field cannot be reverted.\n";

        return false;
    }
    */
}
