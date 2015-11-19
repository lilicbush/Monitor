<br/>
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                {{trigger.title}} ({{trigger.importance_set.title}} <i class="fa fa-flag"
                                                                       style="color:{{trigger.importance_set.color}}"></i>)
                <div class="pull-right">
                    <input type="checkbox" id="activity" class="checkbox-styled" ng-model="activity" ng-true-value="1"
                           ng-false-value="0" ng-change="setActivity()"/>
                    <label for="activity" class="text-normal">Активность</label>
                </div>
            </div>
            <div class="panel-body">

                <a ui-sref="projects.view({id: trigger.project.id})">Проект "{{trigger.project.title}}"</a> <i
                    class="fa fa-long-arrow-right"></i>
                <a ui-sref="sections.triggers({section_id: trigger.section.id})">раздел
                    "{{trigger.section.title}}"</a><br/><br/>

                <ul class="list-group">
                    <li class="list-group-item">
                        <i class="fa fa-database text-success"></i>
                        <strong> База данных: </strong>{{trigger.db}}
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-file-code-o text-success"></i>
                        <strong> Тип: </strong>{{trigger.type}}
                    </li>
                    <li class="list-group-item">
                        <i class="fa fa-book text-success"></i>
                        <strong> Описание: </strong><br/>

                        <div class="well well-sm fs-12">
                            {{trigger.description}}
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="push-down-10">
                            <strong> <i class="fa fa-code text-success"></i> Код: </strong>
                        </div>
                        <code class="well well-sm">
                            {{trigger.code}}
                        </code>

                        <div class="push-down-10"></div>
                    </li>

                    <li class="list-group-item">
                        <div class="push-down-5">
                            <strong> <i class="fa fa-eye text-success"></i> Наблюдатели</strong>:
                            <a href="javascript:void(0)" class="text-success" type="button" class="btn btn-default" ng-click="show_add_observer = !show_add_observer">
                                <i class="fa fa-plus"></i>
                            </a>
                            <form name="observer_form" id="observer_form" ng-show="show_add_observer" my-enter="addObserver()">
                                <div class='input-group col-sm-4'>
                                    <input type='email' ng-model='new_observer' name="new_observer" id="new_observer" class='form-control input-sm' required="true" />
                                    <span class='input-group-btn'>
                                       <input type='button' class='btn btn-default btn-sm' value='ОК' ng-click='addObserver()' ng-disabled="observer_form.$invalid"  />
                                    </span>
                                </div>
                                <small>
                                    <span ng-show="observer_form.new_observer.$error.required">Введите E-Mail наблюдателя.</span>
                                    <span ng-show="observer_form.new_observer.$error.email">Неверный адрес.</span>
                                </small>
                            </form>
                        </div>

                        <small>
                            <ul>
                                <li ng-repeat="observer in trigger.observers">
                                    {{observer}}
                                    <a href="javascript:void(0)" class="text-danger" ng-click="deleteObserver(observer)">
                                        <i class="fa fa-remove"></i>
                                    </a>
                                </li>
                            </ul>
                            <div ng-if="!trigger.observers.length">
                                Пока наблюдателей нет
                            </div>
                        </small>
                    </li>

                    <li class="list-group-item">
                        <a ng-click="run()" class="btn btn-success btn-sm" href="javascript:void(0)">
                            <i class="fa fa-play"></i>
                            &nbsp;
                            Запустить триггер
                        </a>

                        <div class="push-down-10 text-center">
                            <img ng-src="/images/loading.gif" ng-if="loading_trigger"/>
                        </div>
                    </li>

                    <li class="list-group-item">
                        <a ui-sref="triggers.update({trigger_id: trigger.id, section_id: trigger.section.id})"
                           class="btn btn-info btn-sm">Изменить</a>
                        <a class="btn btn-danger btn-sm" ng-click="deleteTrigger(trigger.id)">Удалить</a>
                        <a class="btn btn-default btn-sm" ui-sref="sections.triggers({section_id: trigger.section_id})">Вернуться
                            к списку триггеров</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">События триггера</div>
            <div class="panel-body">
                <a class="btn btn-success btn-xs push-down-10" ng-click="show_add_event_form=!show_add_event_form">Добавить</a>

                <div class="add-event ng-hide cssSlideUp" ng-show="show_add_event_form">
                    <div class="push-down-5"></div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <span ng-if="!event.id">Добавление события</span>
                            <span ng-if="event.id">Изменение события</span>
                        </div>
                        <div class="panel-body">
                            <form ng-submit="submit()" name="form">
                                <div class="form-group">
                                    <label for="time_to_start">Время запуска:</label>
                                    <input type="time" id="time_to_start" name="time_to_start"
                                           ng-model="event.time_to_start" class="form-control" required/>

                                    <div ng-show="form.time_to_start.$invalid">
                                        <span ng-show="form.time_to_start.$error.required">Введите время ежедневного запуска</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="success_result">Ожидаемый результат:</label>
                                    <input type="text" id="success_result" name="success_result"
                                           ng-model="event.success_result" class="form-control" required/>

                                    <div ng-show="form.success_result.$invalid">
                                        <span
                                            ng-show="form.success_result.$error.required">Введите ожидаемый результат</span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="expression">Выражение для сравнения:</label>

                                    <select name='compare_exp' id='compare_exp' ng-model="event.compare_exp"
                                            ng-options="expression.id.toString() as expression.expression for expression in trigger.expressions">

                                    </select>

                                    <div ng-show="form.compare_exp.$invalid">
                                        <span ng-show="form.compare_exp.$error.required">
                                            Выберите выражение для сравнения
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="is_active" id="is_active" name="is_active"
                                                   ng-model="event.is_show" ng-true-value="1" ng-false-value="0"/>
                                            Активное событие:
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Сохранить" class="btn btn-success btn-sm"/>
                                    <input type="button" value="Отмена" class="btn btn-default btn-sm"
                                           ng-click="cancelAddEvent()"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="trigger-events">
                    <uib-accordion>
                        <uib-accordion-group ng-repeat="event_item in trigger.events"
                                             heading="{{event_item.time_to_start | date : 'HH:mm:ss'}} (результат {{trigger.expressions[event_item.compare_exp].expression}} {{event_item.success_result}})"
                            >
                            <div class="pull-right">
                                <input type="checkbox" class="checkbox-styled-2"
                                       id="activity_event_{{event_item.id}}" ng-click="setEventActivity(event_item.id)"
                                       ng-true-value="1" ng-false-value="0" ng-model="event_activities[event_item.id]"/>
                                <label for="activity_event_{{event_item.id}}" class="text-normal">Активность</label>
                            </div>
                            <div class="trigger-event push-down-15">
                                <div class="push-down-10">
                                    <i class="fa fa-clock-o text-success"></i>
                                    <strong>
                                        Время запуска:
                                    </strong>
                                    {{event_item.time_to_start | date : 'HH:mm'}}
                                </div>
                                <i class="fa fa-thumbs-up text-success"></i>
                                <strong>Ожидаемый результат:</strong>
                                {{trigger.expressions[event_item.compare_exp].expression}} {{event_item.success_result}}<br/>
                            </div>
                            <a href="javascript:void(0)" ng-click="runEvent(event_item.id)" class="btn btn-success btn-xs">
                                <i class="fa fa-play"></i>&nbsp;
                                Запустить
                            </a>
                            <input type="button" value="Изменить" class="btn btn-info btn-xs"
                                   ng-click="updateEvent(event_item)"/>
                            <input type="button" value="Удалить" class="btn btn-danger btn-xs"
                                   ng-click="deleteEvent(event_item.id)"/>
                        </uib-accordion-group>
                    </uib-accordion>
                </div>

            </div>
        </div>

        <div ng-if="trigger.last_message" class="panel panel-warning">
            <div class="panel-heading">Последнее сообщение</div>
            <div class="panel-body">
                <p>
                    <small class="text-muted"><i class="fa fa-clock-o"></i> {{trigger.last_message.created_date}}
                    </small>
                </p>
                <div ng-bind-html="trigger.last_message.message" class="push-down-10"></div>

                <div class="text-success" ng-if="trigger.last_message.message_type == 'success'">
                    Статус выполнения: <strong>Выполнено без ошибок</strong>
                </div>
                <div ng-if="trigger.last_message.message_type == 'normal'">
                    Статус выполнения: <strong>Выполнено</strong>
                </div>
                <div class="text-warning" ng-if="trigger.last_message.message_type == 'error'">
                    Статус выполнения: <strong>Ошибка со сравниваемым значением</strong>
                </div>
                <div class="text-danger" ng-if="trigger.last_message.message_type == 'system error'">
                    Статус выполнения: <strong>Системная ошибка</strong>
                </div>

                <div ng-if="trigger.events.length">
                    <h5>Сравнение с значениями событий:</h5>

                    <ul class="list-group">
                        <li class="list-group-item list-group-item-success"
                            ng-repeat="event in trigger.events"
                            ng-if="trigger.events_results[event.id] == 'success'">
                            {{event.time_to_start | date : 'HH:mm'}}
                            ({{trigger.last_message.result_value}}
                            {{trigger.expressions[event['compare_exp']].expression}}
                            {{event.success_result}})
                            <div class="pull-right">
                                <i class="fa fa-thumbs-o-up"></i>
                            </div>
                        </li>

                        <li class="list-group-item list-group-item-danger"
                            ng-repeat="event in trigger.events"
                            ng-if="trigger.events_results[event.id] == 'error'">
                            {{event.time_to_start  | date : 'HH:mm'}}
                            (<span ng-if="trigger.last_message.result_value !== null">{{trigger.last_message.result_value}}</span>
                            <span ng-if="trigger.last_message.result_value === null">Пусто</span>
                            {{trigger.expressions[event['compare_exp']].expression}}
                            {{event.success_result}})
                            <div class="pull-right">
                                <i class="fa fa-thumbs-o-down"></i>
                            </div>
                        </li>
                    </ul>
                    <hr />
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                        Просмотреть все сообщения
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-wide" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Все сообщения триггера <strong>{{trigger.title}}</strong></h4>
            </div>
            <div class="modal-body">
                <div class="all-messages-table">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center">Дата</th>
                                <th class="text-center">Время события</th>
                                <th class="text-center">Результат</th>
                                <th class="text-center">Статус выполнения</th>
                                <th class="text-center">Выражение</th>
                                <th class="text-center">Текст сообщения</th>
                            </tr>
                        </thead>
                        <tbody >
                            <tr ng-repeat="message in last_messages" class="text-center">
                                <td class="text-center">{{message.created_date}}</td>
                                <td class="text-center">
                                    {{message.time_to_start}}
                                    <span ng-if="message.time_to_start == null" class="text-muted">Не установлено</span>
                                </td>
                                <td class="text-center">
                                    <span ng-if="message.result_value == null">Пусто</span>
                                    {{message.result_value}}
                                </td>
                                <td class="text-center">
                                    <div class="text-success" ng-if="message.message_type == 'success'">
                                        <strong>Выполнено без ошибок</strong>
                                    </div>
                                    <div ng-if="message.message_type == 'normal'">
                                        <strong>Выполнено</strong>
                                    </div>
                                    <div class="text-warning" ng-if="message.message_type == 'error'">
                                        <strong>Ошибка со сравниваемым значением</strong>
                                    </div>
                                    <div class="text-danger" ng-if="message.message_type == 'system error'">
                                        <strong>Системная ошибка</strong>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span ng-if="message.success_result !== null">
                                        <span ng-if="message.result_value == null" class="text-muted">Пусто</span>
                                        {{message.result_value}}
                                        {{message.expression}} {{message.success_result}}
                                    </span>
                                    <span ng-if="message.success_result == null" class="text-muted">
                                        Нет события
                                    </span>
                                </td>
                                <td class="message-td">
                                    <div ng-bind-html="message.message"></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <input type="button" ng-click="getLastMessages(trigger.id, current_page)" value="Ранее"
                           class="btn btn-info btn-block" />

            </div>
        </div>
    </div>
</div>