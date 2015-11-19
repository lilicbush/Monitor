<h1>Расписание запуска триггеров</h1>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th class="text-center">Время запуска</th>
            <th>Триггер</th>
            <th class="text-center">Состояние</th>
        </tr>
    </thead>
    <tbody>
        <tr ng-repeat="event in schedule" class="{{event.message_class}}">
            <td class="text-center">
                <i class="fa fa-clock-o text-muted"></i> {{event.time_to_start}}
            </td>
            <td>
                <a ui-sref="triggers.view({trigger_id: event.trigger.id})" class="text-muted">{{event.trigger.title}}</a>
            </td>
            <td class="text-center">
                <div ng-if="event.last_message.message_type == 'success'" class="text-success">
                    Успешно
                </div>
                <div ng-if="event.last_message.message_type == 'error'" class="text-danger">
                    Ошибка!
                </div>
                <div ng-if="event.last_message.message_type == 'system error'" class="text-danger">
                    <strong>Ошибка системы!</strong>
                </div>
                <div ng-if="event.last_message.message_type == 'normal'">
                    <strong>Выполнено триггером</strong>
                </div>
                <div ng-if="!event.last_message">
                    Ожидает выполнения
                </div>
            </td>
        </tr>
    </tbody>
</table>