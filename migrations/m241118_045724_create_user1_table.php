<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m241118_045724_create_user1_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tạo bảng 'user'
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey()->notNull(),  // id chính
            'username' => $this->string(50)->notNull(),  // username
            'password' => $this->string(255)->notNull(),  // password
            'name' => $this->string(100)->notNull(),  // name
            'email' => $this->string(100)->notNull(),  // email
            'role' => $this->string(50)->defaultValue(null),  // role
            'description' => $this->text()->defaultValue(null),  // description
        ]);

        // Thêm chỉ mục cho các cột 'username' và 'email'
        $this->createIndex('idx_user_username', '{{%user}}', 'username');
        $this->createIndex('idx_user_email', '{{%user}}', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Xóa bảng 'user' và các chỉ mục
        $this->dropIndex('idx_user_username', '{{%user}}');
        $this->dropIndex('idx_user_email', '{{%user}}');
        $this->dropTable('{{%user}}');
    }
}
