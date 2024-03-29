<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Вход в систему</h3>
                </div>
                <div class="panel-body">
                    <form role="form" my-enter="submit()">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" ng-required="true" ng-model="user.login" placeholder="Login" name="login" type="text" autofocus />
                            </div>
                            <div class="form-group">
                                <input class="form-control" ng-required="true" ng-model="user.password" placeholder="Password" name="password" type="password" value="" />
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <input type="button" class="btn btn-lg btn-success btn-block" ng-click="submit()" value="Войти" />
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>