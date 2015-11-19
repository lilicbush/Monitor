<div class="row">
    <div class="col-lg-12" ng-controller="TriggersListCtrl">
        <h3 class="page-header">
            <img ng-src="/upload/logos/{{project.logo}}" ng-if="project.logo" class="img-rounded" width="100" height="100" />
            <i class="fa fa-code-fork fa-fw"></i>
            {{section.title}} - триггеры
            <a ui-sref="triggers.create({section_id: section.id})"  class="btn btn-success btn-circle" title="Добавить триггер" >
                <i class="fa fa-plus"></i>
            </a>
            <a ui-sref="sections.update({project_id: section.project_id, section_id: section.id})"  class="btn btn-info btn-circle" title="Редактировать раздел" >
                <i class="fa fa-pencil"></i>
            </a>
            <a class="btn btn-warning btn-circle" title="Удалить раздел" ng-click="deleteSection(section.id)">
                <i class="fa fa-trash"></i>
            </a>
        </h3>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover">
                    <tr ng-repeat="trigger in section.triggers">
                        <td>
                            <i class="fa fa-tasks text-warning" ></i>
                            <a ui-sref="triggers.view({trigger_id: {{trigger.id}}})">
                                {{trigger.title}}
                            </a>
                            <div class="pull-right">
                                <a ui-sref="triggers.update({trigger_id: {{trigger.id}}, section_id: {{section.id}}})"
                                   class="btn btn-info btn-circle" title="Редактировать триггер" >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-warning btn-circle" title="Удалить триггер" ng-click="deleteTrigger(trigger.id)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr ng-if="section.triggers.length == 0">
                        <td>
                            На данный момент триггеров в разделе нет.
                            Вы можете <a ui-sref="triggers.create({section_id: section.id})"  title="Добавить триггер" >добавить</a> новый триггер.
                        </td>
                    </tr>
                </table>
            </div>
            <a class="btn btn-default" ui-sref="projects.view({id: section.project_id})">Вернуться к списку разделов</a>
        </div>
    </div>
</div>