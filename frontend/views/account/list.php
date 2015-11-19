<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Управление пользователями</h3>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <div class="push-down-10">
                    <a ui-sref="users.create()" class="btn btn-success btn-xs">Новый пользователь</a>
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Логин</th>
                            <th>E-Mail</th>
                            <th class="text-center">Операции</th>
                        </tr>
                    </thead>
                    <tr ng-repeat="user in users">
                        <td>
                            <a ui-sref="users.update({id: {{user.id}}})">{{user.username}}</a>
                        </td>
                        <td>
                            {{user.email}}
                        </td>
                        <td class="text-center">
                            <a ui-sref="users.update({id: {{user.id}}})" class="btn btn-circle btn-info">
                                <i class="fa fa-pencil" title="Редактировать"></i>
                            </a>
                            <a ng-click="deleteUser(user.id)" class="btn btn-circle btn-danger">
                                <i class="fa fa-remove" title="Удалить"></i>
                            </a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>