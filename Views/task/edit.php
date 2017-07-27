<div class="container">
    <h3>Редактирование задачи: <?php echo $task->title ?></h3>
    <form class="form-horizontal" action="" method="post">
        <div class="form-group">
            <label class="col-md-2 control-label" for="title">Заголовок</label>
            <div class="col-md-10">
                <input type="text" class="form-control" name="title" placeholder="Заголовок задачи ..." value="<?php echo $task->title ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="password">Описание</label>
            <div class="col-md-10">
                <textarea class="form-control" name="content" placeholder="Описание задачи..." rows="10"><?php echo preg_replace('/\<br(\s*)?\/?\>/i', PHP_EOL, $task->content) ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-md-2 control-label" for="password">Выполнить до</label>
            <div class="col-md-10">
                <input type="text" class="form-control datepicker" name="date_to" placeholder="Запланированная дата..." value="<?php echo $task->date_to ?>">
            </div>
        </div>
        <button type="submit" class="btn btn-success pull-right">Сохранить</button>
    </form>
    <script type="text/javascript" src="/assets/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/css/bootstrap-datepicker.ru.min.js"></script>
    <script>
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            language: 'ru',
            autoclose: true,
            startDate: '-0d'
        });
    </script>
</div>