<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-6" ng-controller="UsersPasswordCtrl">
                <uib-alert template-url="/site/template/alert" ng-repeat="alert in alerts" >{{alert.msg}}</uib-alert>
                <uib-alert template-url="/site/template/alert_error" ng-repeat="error in alerts_errors" >{{error.msg}}</uib-alert>
                <h1 class="page-header">Изменение пароля пользователя</h1>
                <div class="dataTable_wrapper">
                    <form ng-submit="submit()" enctype="multipart/form-data" name="form">
                        <div class="form-group">
                            <label for="title">Старый пароль:</label>
                            <input type="password" id="old_password" name="old_password" ng-model="old_password" class="form-control" required maxlength="50" minlength="2" />
                        </div>

                        <div class="form-group">
                            <label for="title">Новый пароль:</label>
                            <input type="password" id="new_password" name="new_password" ng-model="new_password" class="form-control" required maxlength="20" minlength="6" />
                            <div ng-show="form.new_password.$invalid">
                                <span ng-show="form.new_password.$error.required">Введите новый пароль</span>
                                <span ng-show="form.new_password.$error.maxlength">Пароль не может быть больше 20 символов</span>
                                <span ng-show="form.new_password.$error.mixlength">Пароль не может быть меньше 6 символов</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Подтвердите пароль:</label>
                            <input type="password" id="confirm_password" name="confirm_password" ng-model="confirm_password" class="form-control" required maxlength="20" minlength="6" />
                            <div ng-show="form.confirm_password.$invalid">
                                <span ng-show="form.confirm_password.$error.required">Повторите пароль</span>
                                <span ng-show="form.confirm_password.$error.maxlength">Пароль не может быть больше 20 символов</span>
                                <span ng-show="form.confirm_password.$error.mixlength">Пароль не может быть меньше 6 символов</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
                            <input type="button" value="Отмена" class="btn btn-default" ng-click="cancel()" />
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6"></div>
        </div>
    </div>
</div>