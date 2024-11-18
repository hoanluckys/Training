<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user1}}`.
 */
class mYYYYMMDD_HHMMSS_create_user1_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tạo bảng 'user1'
        $this->createTable('{{%user1}}', [
            'id' => $this->primaryKey()->notNull(),  // id chính
            'username' => $this->string(50)->notNull(),  // username
            'password' => $this->string(255)->notNull(),  // password
            'name' => $this->string(100)->notNull(),  // name
            'email' => $this->string(100)->notNull(),  // email
            'role' => $this->string(50)->defaultValue(null),  // role
            'description' => $this->text()->defaultValue(null),  // description
        ]);

        // Thêm chỉ mục cho các cột 'username' và 'email'
        $this->createIndex('idx_user1_username', '{{%user1}}', 'username');
        $this->createIndex('idx_user1_email', '{{%user1}}', 'email');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Xóa bảng 'user1' và các chỉ mục
        $this->dropIndex('idx_user1_username', '{{%user1}}');
        $this->dropIndex('idx_user1_email', '{{%user1}}');
        $this->dropTable('{{%user1}}');
    }
}
