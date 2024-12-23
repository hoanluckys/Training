<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
//use app\widgets\Alert;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\helpers\Url;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<style>
    .has-error .help-block {
        color: red;
    }
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a {
        padding: 4px 10px;
        border: 1px solid #ddd;
        color: #337ab7;
        text-decoration: none;
    }

    .pagination li.active a {
        background-color: #337ab7;
        color: #fff;
        border-color: #337ab7;
    }

    .pagination li.disabled span {
        color: #aaa;
    }

</style>
<body class="d-flex flex-column h-100" style="background-color: #EEF5F9;">
<?php $this->beginBody() ?>

<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
//            ['label' => 'Home', 'url' => ['/site/index']],
//            ['label' => 'About', 'url' => ['/site/about']],
//            ['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['site/logout'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ]
    ]);
    NavBar::end();
    ?>
</header>
<main id="main" class="flex-shrink-0" role="main" style="padding-top: 56px;">
    <div class="container-fluid">
        <div class="row">
            <!-- Phần aside menu bên trái -->
            <?php if (!Yii::$app->user->isGuest){ ?>
                <aside class="col-lg-3 bg-light p-3">
                    <br>
                    <ul class="nav flex-column">
                        <?php if (Yii::$app->user->can('admin')) { ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="<?= Url::to(['user/index']) ?>">Quản lý User</a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['project/index']) ?>">Quản lý project</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['project-staff/index']) ?>">Quản lý project staff</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['user/profile']) ?>">Thông tin cá nhân</a>
                        </li>
                        <?php if (Yii::$app->user->can('admin')) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= Url::to(['user/statistical']) ?>">Thống kê dự án</a>
                        </li>
                        <?php } ?>
                    </ul>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <?= Html::beginForm(['site/logout'], 'post') ?>
                            <?= Html::submitButton('Đăng xuất', ['class' => 'nav-link']) ?>
                            <?= Html::endForm() ?>
                        </li>
                    </ul>
                </aside>
            <?php } ?>

            <!-- Phần nội dung chính -->
            <div class="col-lg-9">
                <div class="">
                    <!--                    --><?php //if (!empty($this->params['breadcrumbs'])): ?>
                    <!--                        --><?php //= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
                    <!--                    --><?php //endif ?>
                    <?= Alert::widget() ?>
                    <?= $content ?>
                </div>
            </div>
        </div>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
