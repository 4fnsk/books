<?php

use yii\db\Schema;
use yii\db\Migration;

class m151124_100738_create_books_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'date_create' => $this->integer()->notNull(),
            'date_update' => $this->integer()->notNull(),
            'preview' => $this->string()->notNull()->defaultValue('no-preview.png'),
            'date' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('books-authors', '{{%books}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%books}}');
    }
}
