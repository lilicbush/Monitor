<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Выберите базу данных
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <div class="push-down-10">
                    <a ui-sref="db.create()" class="btn btn-success btn-xs">Добавить</a>
                </div>

                <table class="table table-striped table-bordered table-hover">
                    <tr ng-repeat="database in databases">
                        <td>
                            <i class="fa fa-database text-warning" ></i>
                            <a ui-sref="db.update({db_id: {{database.id}}})">
                                {{database.title}}
                            </a>
                            <div class="pull-right">
                                <a ui-sref="db.update({db_id: {{database.id}}})"
                                   class="btn btn-info btn-circle" title="Редактировать БД" >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-warning btn-circle" title="Удалить БД" ng-click="deleteDatabase(database.id)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr ng-if="databases.length == 0">
                        <td>
                            На данный момент базы нет зарегистрированных БД.
                            Вы можете <a ui-sref="db.create()"  title="Добавить БД" >добавить</a> новую БД.
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>