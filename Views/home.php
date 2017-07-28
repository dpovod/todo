<?php if (Request::isUserLoggedIn()) : ?>
    <div class="alert alert-success" role="alert">Для просмотра списка задач перейдите по <a href="/task/tasks">ссылке</a></div>
<?php else : ?>
    <div class="alert alert-warning" role="alert">Для просмотра списка задач <a href="/auth/login">выполните вход</a></div>
<?php endif; ?>
