<?php

use yii\db\Migration;

/**
 * Class m241120_070300_init_rbac_data
 */
class m241120_070300_init_rbac_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $rule = new \app\commands\AuthorRule();
        $ruleview = new \app\commands\ViewProjectRule();
        $auth->add($rule);
        $auth->add($ruleview);

        // Tạo quyền
        $createProject = $auth->createPermission('createProject');
        $createProject->description = 'Tạo dự án mới';
        $auth->add($createProject);

        $updateProject = $auth->createPermission('updateProject');
        $updateProject->description = 'Cập nhật dự án';
        $auth->add($updateProject);

        $deleteProject = $auth->createPermission('deleteProject');
        $deleteProject->description = 'Xóa dự án';
        $auth->add($deleteProject);

        $viewProject = $auth->createPermission('viewProject');
        $viewProject->description = 'Xem dự án';
        $auth->add($viewProject);

        $updateOwnProject = $auth->createPermission('updateOwnProject');
        $updateOwnProject->description = 'Cập nhật dự án cá nhân';
        $updateOwnProject->ruleName = $rule->name;
        $auth->add($updateOwnProject);

        $viewOwnProject = $auth->createPermission('viewOwnProject');
        $viewOwnProject->description = 'Xem dự án cá nhân';
        $viewOwnProject->ruleName = $ruleview->name;
        $auth->add($viewOwnProject);

        $deleteOwnProject = $auth->createPermission('deleteOwnProject');
        $deleteOwnProject->description = 'Xóa dự án cá nhân';
        $deleteOwnProject->ruleName = $rule->name;
        $auth->add($deleteOwnProject);


        // Tạo vai trò và gán quyền cho vai trò admin
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $createProject);
        $auth->addChild($admin, $updateProject);
        $auth->addChild($admin, $deleteProject);
        $auth->addChild($admin, $viewProject);

        //Tạo vai trò và gán quyền cho vai trò projectManagement
        $projectManagement = $auth->createRole('projectManagement');
        $auth->add($projectManagement);
        $auth->addChild($projectManagement, $updateOwnProject);
        $auth->addChild($projectManagement, $viewOwnProject);
        $auth->addChild($projectManagement, $deleteOwnProject);
        $auth->addChild($projectManagement, $createProject);

        //Tạo vai trò và gán quyền cho vai trò staff
        $staff = $auth->createRole('staff');
        $auth->add($staff);
        $auth->addChild($staff, $viewOwnProject);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
//        echo "m241120_070300_init_rbac_data cannot be reverted.\n";
//
//        return false;
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241120_070300_init_rbac_data cannot be reverted.\n";

        return false;
    }
    */
}
