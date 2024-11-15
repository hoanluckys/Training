<?php

use yii\db\Migration;

/**
 * Class m241115_083007_create_rbac_permissions_and_roles
 */
class m241115_083007_create_rbac_permissions_and_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Khởi tạo authManager
        $auth = Yii::$app->authManager;
        // Tạo quyền cho Administrator
        $adminCreateUser = $auth->createPermission('createUser');
        $adminCreateUser->description = 'Create User';
        $auth->add($adminCreateUser);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        // Xóa các quyền đã tạo
        $auth->remove($auth->getPermission('createUser'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241115_083007_create_rbac_permissions_and_roles cannot be reverted.\n";

        return false;
    }
    */
}
