<h5>Текущий проект - <a ui-sref="projects.view({id: project.id})">{{project.title}}</a></h5>
<hr />
<div class="dataTable_wrapper">
    <form ng-submit="submit()" ng-controller="SectionsEditCtrl"  enctype="multipart/form-data" name="form">
        <div class="form-group">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" ng-model="section.title" class="form-control" required maxlength="50" minlength="2" />
            <div ng-show="form.title.$invalid">
                <span ng-show="form.title.$error.required">Введите название раздела</span>
                <span ng-show="form.title.$error.maxlength">Название слишком большое</span>
            </div>
        </div>
        <div class="form-group">
            <label for="project">Проект:</label>
            <select id="project" name="project" class="form-control" ng-options="project_item.id.toString() as project_item.title for project_item in projects"
                    ng-model="section.project_id"></select>
        </div>
        <div class="form-group">
            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
            <input type="button" value="Удалить" class="btn btn-danger" ng-if="section.id" ng-click="deleteSection(section.id)" />
            <input type="button" value="Отмена" class="btn btn-default" ng-click="cancel()" />
        </div>
    </form>
</div>

