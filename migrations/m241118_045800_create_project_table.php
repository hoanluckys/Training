<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m241118_045800_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Tạo bảng 'project'
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey()->notNull(),  // id chính
            'name' => $this->string(100)->notNull(),  // name
            'projectManagerId' => $this->integer(11)->notNull(),  // projectManagerId
            'description' => $this->text()->defaultValue(null),  // description
            'createDate' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),  // createDate
            'updateDate' => $this->dateTime()->defaultValue(null)->append('ON UPDATE CURRENT_TIMESTAMP'),  // updateDate
        ]);

        // Thêm chỉ mục cho cột 'projectManagerId'
        $this->createIndex('idx_project_projectManagerId', '{{%project}}', 'projectManagerId');

        // Thêm khóa ngoại ràng buộc với bảng 'user'
        $this->addForeignKey(
            'fk_project_projectManagerId',
            '{{%project}}',
            'projectManagerId',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Xóa khóa ngoại trước khi xóa bảng
        $this->dropForeignKey('fk_project_projectManagerId', '{{%project}}');

        // Xóa chỉ mục và bảng 'project'
        $this->dropIndex('idx_project_projectManagerId', '{{%project}}');
        $this->dropTable('{{%project}}');
    }
}
