<?php require_once __DIR__ . "/../../Models/User.php" ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Главная</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script type="text/javascript" href="/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row">
    <div class="wrapper">
        <header class="clearfix">
            <div class="row">
                <div class="col-md-6 pull-left">
                    <ul class="pull-left nav nav-pills">
                        <li role="presentation"><a href="/">Главная</a></li>
                    </ul>
                </div>
                <div class="col-md-6 pull-left">
                    <?php if (Request::isUserLoggedIn()) { ?>
                        <ul class="pull-right nav nav-pills">
                            <li role="presentation" class="active disabled">
                                <a href="javascript:void(0);">
                                    <?php echo \Models\User::getLoggedUserEmail() ?>
                                </a>
                            </li>
                            <li role="presentation"><a href="/task/tasks">Задачи</a></li>
                            <li role="presentation"><a href="/auth/logout">Выход</a></li>
                        </ul>
                    <?php } else { ?>
                        <ul class="pull-right nav nav-pills">
                            <li role="presentation"><a href="/auth/register">Регистрация</a></li>
                            <li role="presentation"><a href="/auth/login">Вход</a></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="row">
                <?php if (!empty($errors)) { ?>
                    <?php foreach ($errors as $error) { ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
                    <?php } ?>
                <?php } ?>
                <?php if (!empty($success)) { ?>
                    <div class="alert alert-success" role="alert"><?php echo $success ?></div>
                <?php } ?>

            </div>
            <?php include 'Views/' . $contentView . '.php'; ?>
        </div>

    </div>
</div>

</body>
</html>