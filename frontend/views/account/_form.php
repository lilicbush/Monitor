<div class="dataTable_wrapper">
    <form ng-submit="submit()" enctype="multipart/form-data" name="form">
        <div class="form-group">
            <label for="username">Логин:</label>
            <input type="text" id="username" name="username" ng-model="user.username" class="form-control" required maxlength="50" minlength="2" />
            <div ng-show="form.username.$invalid">
                <span ng-show="form.username.$error.required">Введите логин</span>
                <span ng-show="form.username.$error.maxlength">Логин слишком большой (больше 50 символов)</span>
            </div>
        </div>

        <div class="form-group">
            <label for="email">E-Mail:</label>
            <input type="email" id="email" name="email" ng-model="user.email" class="form-control" required maxlength="50" minlength="2" />
            <div ng-show="form.email.$invalid">
                <span ng-show="form.email.$error.email">Необходимо ввести верный E-Mail адрес</span>
            </div>
        </div>

        <div class="form-group" ng-if="user.id">
            <div class="checkbox">
                <label>
                    <input type="checkbox" id="is_active" ng-model="change_password" ng-true-value="1" ng-false-value="0" >
                    Изменить пароль:
                </label>
            </div>
        </div>

        <div ng-if="change_password">
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" ng-model="user.password" class="form-control" required maxlength="50" minlength="6" />
                <div ng-show="form.password.$invalid">
                    <span ng-show="form.password.$error.required">Необходимо ввести пароль</span>
                    <span ng-show="form.password.$error.minlength">Пароль должен быть не менее 6 символов</span>
                    <span ng-show="form.password.$error.maxlength">Пароль должен быть не более 50 символов</span>
                </div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Подтвердите пароль:</label>
                <input type="password" id="confirm_password" name="confirm_password" ng-model="user.confirm_password" class="form-control" required maxlength="50" minlength="6" />
                <div ng-show="form.confirm_password.$invalid">
                    <span ng-show="form.confirm_password.$error.required">Необходимо подтвердить пароль</span>
                    <span ng-show="form.confirm_password.$error.minlength">Пароль должен быть не менее 6 символов</span>
                    <span ng-show="form.confirm_password.$error.maxlength">Пароль должен быть не более 50 символов</span>
                </div>
            </div>
        </div>

        <div class="form-group">
            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
            <input type="button" value="Удалить" class="btn btn-danger" ng-if="user.id" ng-click="deleteUser(user.id)" />
            <a ui-sref="users.list()" class="btn btn-default">Отмена</a>
        </div>
    </form>
</div>

