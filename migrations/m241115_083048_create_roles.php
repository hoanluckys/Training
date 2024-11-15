<?php

use yii\db\Migration;

/**
 * Class m241115_083048_create_roles
 */
class m241115_083048_create_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        // Tạo vai trò 'Administrator'
        $adminRole = $auth->createRole('administrator');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $auth->getPermission('createUser'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;
        $auth->remove($auth->getRole('administrator'));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241115_083048_create_roles cannot be reverted.\n";

        return false;
    }
    */
}
