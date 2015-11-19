<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Результаты поиска по запросу <strong>{{search}}</strong>
        </h1>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="dataTable_wrapper">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <span class="badge">{{result.projects.length}}</span>
                            Проекты:
                            <ul>
                                <li ng-repeat="project in result.projects">
                                    <a ui-sref="projects.view({id: project.id})">{{project.title}}</a>
                                    <br />
                                    <small class="text-muted">
                                        {{project.description}}
                                    </small>
                                </li>
                            </ul>
                            <small class="text-muted" ng-if="result.projects.length == 0">По запросу проектов не найдено</small>
                        </li>
                        <li class="list-group-item">
                            <span class="badge">{{result.sections.length}}</span>
                            Разделы:
                            <ul>
                                <li ng-repeat="section in result.sections">
                                    <a ui-sref="sections.triggers({section_id: section.id})">{{section.title}}</a>
                                </li>
                            </ul>
                            <small class="text-muted" ng-if="result.sections.length == 0">По запросу разделов не найдено</small>
                        </li>
                        <li class="list-group-item">
                            <span class="badge">{{result.triggers.length}}</span>
                            Триггеры:
                            <ul>
                                <li ng-repeat="trigger in result.triggers">
                                    <a ui-sref="triggers.view({trigger_id: trigger.id})">{{trigger.title}}</a>
                                    <br />
                                    <small class="text-muted">
                                        {{trigger.description}}
                                    </small>
                                </li>
                            </ul>
                            <small class="text-muted" ng-if="result.triggers.length == 0">По запросу триггеров не найдено</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>