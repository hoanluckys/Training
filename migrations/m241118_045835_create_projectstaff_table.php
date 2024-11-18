<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%projectstaff}}`.
 */
class mYYYYMMDD_HHMMSS_create_projectstaff_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tạo bảng 'projectstaff'
        $this->createTable('{{%projectstaff}}', [
            'id' => $this->primaryKey()->notNull(),  // id chính
            'projectId' => $this->integer(11)->notNull(),  // projectId
            'userId' => $this->integer(11)->notNull(),  // userId
        ]);

        // Thêm chỉ mục cho cột 'projectId' và 'userId'
        $this->createIndex('idx_projectstaff_projectId', '{{%projectstaff}}', 'projectId');
        $this->createIndex('idx_projectstaff_userId', '{{%projectstaff}}', 'userId');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Xóa chỉ mục và bảng 'projectstaff'
        $this->dropIndex('idx_projectstaff_projectId', '{{%projectstaff}}');
        $this->dropIndex('idx_projectstaff_userId', '{{%projectstaff}}');
        $this->dropTable('{{%projectstaff}}');
    }
}
