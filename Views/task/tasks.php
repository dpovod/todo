<div class="container">
    <div style="overflow: hidden">
        <div class="col-md-6">
            <h3 class="mar-t-10">Все задачи</h3>
        </div>
        <div class="col-md-6 text-right clearfix">
            <a class="btn btn-success" href="/task/create">Добавить</a>
        </div>
    </div>

    <div class="container" style="max-width: 100%;">
        <div class="dropdown pull-right">
            <button class="btn btn-xs dropdown-toggle mar-b-10" type="button" data-toggle="dropdown">
                <?php echo ($sort == 'asc') ? 'срочные в начале' : 'срочные в конце' ?>
                <span class="caret"></span></button>
            <ul class="dropdown-menu">
                <li><a href="/<?php echo $url ?>?sort=desc">срочные в конце</a></li>
                <li><a href="/<?php echo $url ?>?sort=asc">срочные в начале</a></li>
            </ul>
        </div>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>
                <div class="checkbox" style="height: 10px;">
                    <input type="checkbox" class="check-all">
                </div>
            </th>
            <th>Заголовок</th>
            <th>Описание</th>
            <th>Назначена</th>
            <th>Выполнена</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tasks as $task) : ?>
            <tr>
                <td>
                    <div class="checkbox">
                        <input type="checkbox" data-id="<?php echo $task->id ?>">
                    </div>
                </td>
                <td><?php echo $task->title ?></td>
                <td><?php echo mb_substr($task->content, 0, 100) ?></td>
                <td><?php echo $task->date_to ?></td>
                <td><?php echo $task->complete ? 'Да' : 'Нет' ?></td>
                <td>
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" id="menu1" type="button" data-toggle="dropdown">
                            &#8942;
                        </button>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
                            <li role="presentation">
                                <a class="change-task-status" role="menuitem" tabindex="-1" href="javascript:void(0);" data-complete="<?php echo !$task->complete ?>" data-id="<?php echo $task->id ?>">
                                    <?php echo $task->complete ? 'Не выполнено' : 'Выполнено' ?>
                                </a>
                            </li>
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" href="/task/edit?id=<?php echo $task->id ?>">Редактировать</a>
                            </li>
                            <li role="presentation" class="divider"></li>
                            <li role="presentation">
                                <a class="delete-task" role="menuitem" tabindex="-1" href="javascript:void(0);" data-id="<?php echo $task->id ?>">
                                    Удалить
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="container mass-actions" style="visibility: hidden;">
        <a class="btn btn-success complete">Выполнено</a>
        <a class="btn btn-warning uncomplete">Не выполнено</a>
        <a class="btn btn-danger delete">Удалить</a>
    </div>
    <div class="container">
        <?php if (!empty($links)) : ?>
            <ul class="pagination">
                <?php foreach ($links as $page => $link) : ?>
                    <li class="<?php echo $link['class'] ?>"><a href="<?php echo $link['url'] ?>"><?php echo $page ?></a></li>
                <?php endforeach; ?>
            <ul>
        <?php endif; ?>
    </div>
</div>
<form class="delete-task-form" action="/task/delete" method="post">
    <input name="ids" value="" type="hidden">
</form>

<form class="change-task-status-form" action="/task/status" method="post">
    <input name="ids" value="" type="hidden">
    <input name="complete" value="" type="hidden">
</form>
<script>
    $('.change-task-status').on('click', function () {
        $('.change-task-status-form input[name="ids"]').val($(this).data('id'));
        $('.change-task-status-form input[name="complete"]').val($(this).data('complete'));
        $('.change-task-status-form').submit();
    });

    $('.delete-task').on('click', function () {
        $('.delete-task-form input[name="ids"]').val($(this).data('id'));
        $('.delete-task-form').submit();
    });

    $('.checkbox input[type="checkbox"]').on('change', function () {
        if ($(this).hasClass('check-all')) {
            if ($(this).prop('checked') == true) {
                $('.checkbox:not(.check-all) input[type="checkbox"]').each(function () {
                    $(this).prop('checked', 'checked');
                });
            } else {
                $('.checkbox:not(.check-all) input[type="checkbox"]').each(function () {
                    $(this).prop('checked', false);
                });
            }
        }

        if ($('.checkbox:not(.check-all) input[type="checkbox"]:checked').length > 0) {
            $('.mass-actions').addClass('visible');
        } else {
            $('.mass-actions').removeClass('visible');
        }
    });

    $('.mass-actions a').on('click', function () {
        idArray = [];

        $('.checkbox:not(.check-all) input[type="checkbox"]:checked').each(function () {
            idArray.push($(this).data('id'));
        });

        if ($(this).hasClass('delete')) {
            $('.delete-task-form input[name="ids"]').val(idArray.join('-'));
            $('.delete-task-form').submit();
        } else {
            $('.change-task-status-form input[name="ids"]').val(idArray.join('-'));

            if ($(this).hasClass('complete')) {
                $('.change-task-status-form input[name="complete"]').val(1);
            } else {
                $('.change-task-status-form input[name="complete"]').val(0);
            }

            $('.change-task-status-form').submit();
        }
    });
</script>
