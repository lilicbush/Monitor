<h5>
    Текущий раздел - <a ui-sref="sections.triggers({section_id: section.id})">{{section.title}}</a>
    (проект <a ui-sref="projects.view({id: project.id})">{{project.title}}</a>)
</h5>

<hr />
<div class="dataTable_wrapper">
    <form ng-submit="submit()" enctype="multipart/form-data" name="form">
        <div class="form-group">
            <label for="title">Название:</label>
            <input type="text" id="title" name="title" ng-model="trigger.title" class="form-control" required maxlength="50" minlength="2" />
            <div ng-show="form.title.$invalid">
                <span ng-show="form.title.$error.required">Введите название триггера</span>
                <span ng-show="form.title.$error.maxlength">Название слишком большое</span>
            </div>
        </div>

        <div class="form-group">
            <label for="project">Раздел:</label>
            <select id="project" name="project" class="form-control"
                    ng-options="section_item.id.toString() as section_item.title group by section_item.project.title for section_item in sections"
                    ng-model="trigger.section_id">
            </select>
        </div>

        <div class="form-group">
            <label for="description">Описание:</label>
            <textarea id="description" name="description" ng-model="trigger.description" class="form-control" required maxlength="2000" minlength="2"></textarea>
            <div ng-show="form.description.$invalid">
                <span ng-show="form.description.$error.required">Введите описание триггера</span>
                <span ng-show="form.description.$error.maxlength">Название слишком большое</span>
            </div>
        </div>

        <div class="form-group">
            <label for="type">Тип:</label>
            <select id="type" name="type" ng-required="true" class="form-control" ng-options="type.id.toString() as type.title for type in trigger_types"
                    ng-model="trigger.trigger_type"></select>
            <div ng-show="form.type.$invalid">
                <span ng-show="form.type.$error.required">Выберите тип триггера</span>
            </div>
        </div>

        <div class="form-group">
            <label>Важность триггера:</label>
            <label class="radio-inline"  ng-repeat="importance_item in importance_items">
                <input type="radio" ng-required="true" name="importance" id="importance" value="{{importance_item.id}}" ng-model="trigger.importance"  />
                <span style="color: {{importance_item.color}}">{{importance_item.title}}</span>
            </label>
            <div ng-show="form.importance.$invalid">
                <span ng-show="form.importance.$error.required">Выберите важность триггера</span>
            </div>
        </div>

        <div class="form-group">
            <label for="db_id">База данных:</label>
            <select id="db_id" name="db_id" ng-required="true" class="form-control" ng-options="database.id.toString() as database.title group by database.dbms.name for database in databases"
                    ng-model="trigger.db_id"></select>
            <div ng-show="form.db_id.$invalid">
                <span ng-show="form.db_id.$error.required">Выберите базу данных</span>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="is_active" id="is_active" name="is_active" ng-model="trigger.is_active" ng-true-value="1" ng-false-value="0" />
                    Активный:
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="code">Код:</label>
            <textarea id="code" name="code" ng-model="trigger.code" class="form-control" required minlength="2"></textarea>
            <div ng-show="form.code.$invalid">
                <span ng-show="form.code.$error.required">Введите код триггера</span>
            </div>
        </div>

        <div class="form-group">
            <input ng-disabled="form.$invalid || errors.code" type="submit" value="Сохранить" class="btn btn-success" />
            <input type="button" value="Удалить" class="btn btn-danger" ng-if="trigger.id" ng-click="deleteTrigger(trigger.id)" />
            <input type="button" value="Отмена" class="btn btn-default" ng-click="cancel()" />
        </div>
    </form>
</div>

