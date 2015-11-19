<div id="wrapper">
    <header></header>
    <div id="page-wrapper" style="min-height: 561px;">

        <div ui-view>
            <h1>Выберите проект</h1>

            <div class="list-group">
                <div class="list-group-item" ng-repeat="project in projects" >
                    <div class="media">
                        <div class="media-left">
                            <a ui-sref="projects.view({id: project.id})">
                                <img ng-if="!project.logo" class="media-object img-rounded"
                                     ng-src="/images/xcodeproject.png" width="100" height="100"/>
                                <img ng-if="project.logo" class="media-object img-rounded"
                                     ng-src="/upload/logos/{{project.logo}}" width="100" height="100"/>
                            </a>
                        </div>
                        <div class="media-body">
                            <a ui-sref="projects.view({id: project.id})">
                                <h4 class="media-heading">{{project.title}}</h4>
                            </a>

                            <div ng-if="project.triggers.length" class="projects-triggers">
                                <small>
                                    <strong>Триггеры:</strong>
                                    <ul class="text-muted">
                                        <li ng-repeat="trigger in project.triggers">
                                            <a ui-sref="sections.triggers({section_id: {{trigger.section_id}}})">
                                                {{trigger.section_title}}
                                            </a>
                                            <i class="fa fa-long-arrow-right"></i>
                                            <a ui-sref="triggers.view({trigger_id: {{trigger.trigger_id}}})">{{trigger.trigger_title}}</a>
                                            <ul>
                                                <li ng-if="trigger.last_message.message_type == 'error' || trigger.last_message.message_type == 'system error'"
                                                    class="text-danger" ng-bind-html="trigger.last_message.message">
                                                </li>
                                                <li ng-if="trigger.last_message.message_type == 'normal'"
                                                    ng-bind-html="trigger.last_message.message">
                                                </li>
                                                <li ng-if="trigger.last_message.message_type == 'success'"
                                                    ng-bind-html="trigger.last_message.message" class="text-success">
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </small>
                            </div>
                            <div ng-if="!project.triggers.length" class="text-muted">
                                Триггеров в проекте нет
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- /#page-wrapper -->
</div>
