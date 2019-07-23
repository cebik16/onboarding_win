<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m190723_094956_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comment}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unsigned(),
            'task_id' => $this->integer()->notNull()->unsigned(),
            'text' => $this->text()->notNull(),
    
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
