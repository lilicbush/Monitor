<div class="row">
    <div class="col-lg-12" ng-controller="SectionsListCtrl">
        <h1 class="page-header">
            <img ng-src="/upload/logos/{{project.logo}}" ng-if="project.logo" class="img-rounded" width="100" height="100" />
            {{project.title}} - разделы
            <a ui-sref="sections.create({project_id: project.id})"  class="btn btn-success btn-circle" title="Добавить раздел" >
                <i class="fa fa-plus"></i>
            </a>
            <a ui-sref="projects.update({id: project.id})"  class="btn btn-info btn-circle" title="Редактировать проект" >
                <i class="fa fa-pencil"></i>
            </a>
            <a class="btn btn-warning btn-circle" title="Удалить проект" ng-click="deleteProject()">
                <i class="fa fa-trash"></i>
            </a>
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover">
                    <tr ng-repeat="section in project.sections">
                        <td>
                            <a ui-sref="sections.triggers({section_id: {{section.id}}})">{{section.title}}</a>
                            <div class="pull-right">
                                <a ui-sref="sections.update({section_id: {{section.id}}, project_id: {{project.id}}})"  class="btn btn-info btn-circle" title="Редактировать раздел" >
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <a class="btn btn-warning btn-circle" title="Удалить раздел" ng-click="deleteSection(section.id)">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr ng-if="project.sections.length == 0">
                        <td>
                            На данный момент разделов в проекте нет.
                            Вы можете <a ui-sref="sections.create({project_id: project.id})"  title="Добавить раздел" >добавить</a> новый раздел.
                        </td>
                    </tr>
                </table>
            </div>
            <a class="btn btn-default" ui-sref="projects">Вернуться к списку проектов</a>
        </div>
    </div>
</div>