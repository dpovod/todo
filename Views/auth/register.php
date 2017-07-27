<div class="panel panel-default auth-form">
    <div class="panel-heading">Регистрация</div>
    <div class="panel-body">
        <form class="form-horizontal" action="/auth/register" method="post">
            <div class="form-group">
                <label class="col-md-4 control-label" for="email">Email</label>
                <div class="col-md-8">
                    <input type="email" class="form-control" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label" for="password">Пароль</label>
                <div class="col-md-8">
                    <input type="password" class="form-control" name="password" placeholder="Пароль">
                </div>
            </div>
            <button type="submit" class="btn btn-default pull-right">Регистрация</button>
        </form>
    </div>
</div>
