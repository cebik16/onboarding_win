<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m190722_092839_create_project_table extends Migration
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
        
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'start_date' => $this->date()->notNull(),
            'duration' => $this->integer()->notNull(),
    
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }
}
