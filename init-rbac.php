<?php

use Yii;

require __DIR__ . '/yii';
$application = new yii\console\Application(require __DIR__ . '/config/console.php');

$auth = Yii::$app->authManager;

// Tạo quyền
$createPost = $auth->createPermission('createPost');
$createPost->description = 'Create a post';
$auth->add($createPost);

$updatePost = $auth->createPermission('updatePost');
$updatePost->description = 'Update a post';
$auth->add($updatePost);

// Tạo vai trò
$author = $auth->createRole('author');
$author->description = 'Author role';
$auth->add($author);

$admin = $auth->createRole('admin');
$admin->description = 'Admin role';
$auth->add($admin);

// Gán quyền vào vai trò
$auth->addChild($author, $createPost);
$auth->addChild($admin, $createPost);
$auth->addChild($admin, $updatePost);
$auth->addChild($admin, $author); // Admin thừa hưởng quyền của 'author'

echo "Quyền, vai trò, và gán vai trò đã được thiết lập thành công.\n";
