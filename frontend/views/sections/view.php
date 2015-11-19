<div class="row">
    <div class="col-lg-12" ng-controller="SectionsListCtrl">
        <h1 class="page-header">
        </h1>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover">
                    <tr ng-repeat="section in project.sections">
                        <td>
                            <a ui-sref="projects.section({id: {{section.id}}})">{{section.title}}</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>