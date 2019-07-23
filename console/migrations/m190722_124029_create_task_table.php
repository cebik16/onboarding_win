<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m190722_124029_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'status' => $this->smallInteger()->notNull(),
            'attachment' => $this->string()->defaultValue(NULL),
            'user_id' => $this->integer()->notNull(),
            'project_id' => $this->integer()->notNull(),
    
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
