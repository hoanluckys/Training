<?php

use yii\db\Migration;

/**
 * Class m240101_123456_init_rbac_data
 */
class m241119_092644_init_rbac_data extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // Tạo quyền
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users (create, edit, delete)';
        $auth->add($manageUsers);

        $manageProjects = $auth->createPermission('manageProjects');
        $manageProjects->description = 'Manage projects (create, edit, delete)';
        $auth->add($manageProjects);

        $assignProjectManager = $auth->createPermission('assignProjectManager');
        $assignProjectManager->description = 'Assign project manager to a project';
        $auth->add($assignProjectManager);

        $viewAccountDetails = $auth->createPermission('viewAccountDetails');
        $viewAccountDetails->description = 'View account details';
        $auth->add($viewAccountDetails);

        $changePassword = $auth->createPermission('changePassword');
        $changePassword->description = 'Change password';
        $auth->add($changePassword);

        $forgotPassword = $auth->createPermission('forgotPassword');
        $forgotPassword->description = 'Forgot password';
        $auth->add($forgotPassword);

        $viewProjectStats = $auth->createPermission('viewProjectStats');
        $viewProjectStats->description = 'View project statistics';
        $auth->add($viewProjectStats);

        $manageOwnProjects = $auth->createPermission('manageOwnProjects');
        $manageOwnProjects->description = 'Manage own projects';
        $auth->add($manageOwnProjects);

        $addStaffToProject = $auth->createPermission('addStaffToProject');
        $addStaffToProject->description = 'Add staff to a project';
        $auth->add($addStaffToProject);

        $viewAssignedProjects = $auth->createPermission('viewAssignedProjects');
        $viewAssignedProjects->description = 'View assigned projects';
        $auth->add($viewAssignedProjects);

        $viewProjectDetails = $auth->createPermission('viewProjectDetails');
        $viewProjectDetails->description = 'View project details';
        $auth->add($viewProjectDetails);

        // Tạo vai trò
        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $manageUsers);
        $auth->addChild($adminRole, $manageProjects);
        $auth->addChild($adminRole, $assignProjectManager);
        $auth->addChild($adminRole, $viewAccountDetails);
        $auth->addChild($adminRole, $changePassword);
        $auth->addChild($adminRole, $forgotPassword);
        $auth->addChild($adminRole, $viewProjectStats);

        $projectManagementRole = $auth->createRole('projectManagement');
        $auth->add($projectManagementRole);
        $auth->addChild($projectManagementRole, $manageOwnProjects);
        $auth->addChild($projectManagementRole, $addStaffToProject);
        $auth->addChild($projectManagementRole, $viewAccountDetails);
        $auth->addChild($projectManagementRole, $changePassword);
        $auth->addChild($projectManagementRole, $forgotPassword);

        $staffRole = $auth->createRole('staff');
        $auth->add($staffRole);
        $auth->addChild($staffRole, $viewAssignedProjects);
        $auth->addChild($staffRole, $viewProjectDetails);
        $auth->addChild($staffRole, $viewAccountDetails);
        $auth->addChild($staffRole, $changePassword);
        $auth->addChild($staffRole, $forgotPassword);

        // Gán vai trò cho người dùng (ví dụ)
        // $auth->assign($adminRole, 1);  // Gán vai trò admin cho người dùng có ID 1
        // $auth->assign($projectManagementRole, 2);  // Gán vai trò projectManagement cho người dùng có ID 2
        // $auth->assign($staffRole, 3);  // Gán vai trò staff cho người dùng có ID 3
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        // Xóa quyền
        $auth->removeAll();

        // Nếu cần có thể xóa các quyền, vai trò và gán lại theo cách thủ công nếu cần.
    }
}
