<div class="dataTable_wrapper">
    <form ng-submit="submit()" enctype="multipart/form-data" name="form">
        <div class="form-group">
            <label for="title">Заголовок для системы:</label>
            <input type="text" id="title" name="title" ng-model="database.title" class="form-control" required maxlength="100" minlength="2" />
            <div ng-show="form.title.$invalid">
                <span ng-show="form.title.$error.required">Введите заголовок</span>
                <span ng-show="form.title.$error.maxlength">Заголовок слишком большой</span>
            </div>
        </div>

        <div class="form-group">
            <label for="dbname">Название:</label>
            <input type="text" id="dbname" name="dbname" ng-model="database.dbname" class="form-control" required minlength="2" maxlength="255" />
            <div ng-show="form.dbname.$invalid">
                <span ng-show="form.dbname.$error.required">Введите название базы данных</span>
                <span ng-show="form.dbname.$error.maxlength">Имя БД слишком большое</span>
            </div>
        </div>

        <div class="form-group">
            <label for="dbms_id">СУБД:</label>
            <select id="dbms_id" name="dbms_id" class="form-control"
                    ng-options="dbms_item.id.toString() as dbms_item.name for dbms_item in dbms"
                    ng-model="database.dbms_id">
            </select>
            <div ng-show="form.dbms_id.$invalid">
                <span ng-show="form.dbms_id.$error.required">Выберите СУБД</span>
            </div>
        </div>

        <div class="form-group">
            <label for="dsn">DSN:</label>
            <input type="text" id="dsn" name="dsn" ng-model="database.dsn" class="form-control" required minlength="2" maxlength="255" />
            <div ng-show="form.dsn.$invalid">
                <span ng-show="form.dsn.$error.required">Введите DSN</span>
                <span ng-show="form.dsn.$error.maxlength">DSN слишком большой</span>
            </div>
        </div>

        <div class="form-group">
            <label for="username">Имя пользователя:</label>
            <input type="text" id="username" name="username" ng-model="database.username" class="form-control" required minlength="2" maxlength="255" />
            <div ng-show="form.username.$invalid">
                <span ng-show="form.username.$error.required">Введите имя пользователя</span>
                <span ng-show="form.username.$error.maxlength">Имя пользователя слишком большое</span>
            </div>
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" ng-model="database.password" class="form-control" required minlength="2" maxlength="255" />
            <div ng-show="form.password.$invalid">
                <span ng-show="form.password.$error.required">Введите пароль</span>
                <span ng-show="form.password.$error.maxlength">Пароль слишком большой</span>
            </div>
        </div>

        <div class="form-group">
            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
            <input type="button" ng-click="testConnect()" value="Протестировать" class="btn btn-info" />
            <input type="button" value="Удалить" class="btn btn-danger" ng-if="database.id" ng-click="deleteDatabase(database.id)" />
            <a ui-sref="db.list()" class="btn btn-default">Отмена</a>
        </div>
    </form>
</div>

