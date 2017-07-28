<?php require_once __DIR__ . "/../../Models/User.php" ?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>TODO List</title>
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="row">
    <div class="wrapper">
        <header class="clearfix">
            <div class="row">
                <div class="col-md-6">
                    <ul class="pull-left nav nav-pills">
                        <li role="presentation"><a href="/">Главная</a></li>
                    </ul>
                </div>
                <div class="col-md-6 pad-r-0">
                    <?php if (Request::isUserLoggedIn()) : ?>
                        <div class="pull-right">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" id="menu2" type="button" data-toggle="dropdown">
                                    <a href="javascript:void(0);">
                                        <?php echo \Models\User::getLoggedUserEmail() ?>
                                    </a>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="menu2">
                                    <li role="presentation">
                                        <a role="menuitem" tabindex="-1" href="/task/tasks">Задачи</a>
                                    </li>
                                    <li role="presentation" class="divider"></li>
                                    <li role="presentation">
                                        <a class="delete-task" role="menuitem" tabindex="-1" href="/auth/logout">Выход</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    <?php else : ?>
                        <ul class="pull-right nav nav-pills">
                            <li role="presentation"><a href="/auth/register">Регистрация</a></li>
                            <li role="presentation"><a href="/auth/login">Вход</a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <div class="content">
            <div class="row">
                <?php if (!empty($errors)) : ?>
                    <?php foreach ($errors as $error) : ?>
                        <div class="alert alert-danger" role="alert"><?php echo $error ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($success)) : ?>
                    <div class="alert alert-success" role="alert"><?php echo $success ?></div>
                <?php endif; ?>
            </div>
            <?php include 'Views/' . $contentView . '.php'; ?>
        </div>

    </div>
</div>
<script>
    setTimeout(function () {
        $(".alert-success").fadeTo(1000, 500).slideUp(500, function(){
            $(".alert-success").alert('close');
        });
    }, 2000);
</script>
</body>
</html>
