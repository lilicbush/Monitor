<div class="dataTable_wrapper">
    <form ng-submit="submit()" ng-controller="ProjectEditCtrl"  enctype="multipart/form-data" name="form">
        <div class="form-group">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" ng-model="project.title" class="form-control" required maxlength="50" minlength="2" />
            <div ng-show="form.title.$invalid">
                <span ng-show="form.title.$error.required">Введите название проекта</span>
                <span ng-show="form.title.$error.maxlength">Название слишком большое</span>
            </div>
        </div>
        <div class="form-group">
            <label for="title">Описание:</label>
            <textarea id="description" name="description" ng-model="project.description" class="form-control"  maxlength="2000" required></textarea>
            <div ng-show="form.description.$invalid">
                <span ng-show="form.description.$error.required">Опишите проект</span>
                <span ng-show="form.description.$error.maxlength">Описание не должно превышать 2000 символов</span>
            </div>
        </div>
        <div class="form-group">
            <label for="title">Логотип:</label>
            <input type="file" name="logo" id="logo" ng-model="project.logo" oi-file="options" />
        </div>

        <div class="form-group" ng-if="project.logo">
            <label for="title">Текущий логотип:</label><br />

            <div class="media">
                <div class="media-left">
                    <img class="media-object img-rounded" width="100" height="100" ng-src="/upload/logos/{{project.logo}}" />
                </div>
                <div class="media-body">
                    <a ng-click="removeProjectLogo()" href="javascript:void(0)" class="text-danger">
                        <i class="fa fa-remove"></i>
                    </a>
                </div>
            </div>
        </div>

        <div class="form-group">
            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
            <input type="button" value="Удалить" class="btn btn-danger" ng-if="project.id" ng-click="deleteProject()" />
            <input type="button" value="Отмена" class="btn btn-default" ng-click="cancel()" />
        </div>
    </form>
</div>

