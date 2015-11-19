"use strict";

angular.module('sbAdminApp').controller('TriggersEditCtrl',
    ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Section', 'Trigger', 'Helper',
    function ($scope, $rootScope, $http, $stateParams, $location, Section, Trigger, Helper) {

        if ($stateParams.section_id == undefined) {
            alert('Для редактирования триггеров необходим активный раздел');
            return false;
        }

        // Список разделов для поля выбора проекта
        Section.getList().then(function (result) {
                $scope.sections = result.data;
            }
        );

        // Данные о текущем разделе
        Section.getForeignData($stateParams.section_id).then(function (result) {
                $.each(result.data, function (key, data) {
                    $scope[key] = data;
                });
            }
        );

        // Работа с сообщениями
        $scope.alerts = [];

        $scope.addAlert = function (msg) {
            $scope.alerts.push({msg: msg, type: 'success'});
        };

        // Кнопка отмены
        $scope.cancel = function () {
            setTimeout(function () {
                $scope.$apply(function () {
                    $location.path("/sections/triggers/" + $scope.section.id);
                });
            }, 0);
        }

        // Функция используется для создания и редактирования, если создаем новый триггер то на начальном этапе у нас известен только section_id
        if ($stateParams.trigger_id != undefined) {

            Trigger.getInfo($stateParams.trigger_id).then(function (result) {
                    $scope.trigger = Helper.prepareObject(result.data);
                }
            )

        } else {
            $scope.trigger = {section_id: $stateParams.section_id.toString()}
        }

        $scope.deleteTrigger = function (trigger_id) {
            if (!confirm('Вы действительно хотите удалить триггер и все его данные?')) {
                return false;
            }

            Trigger.deleteTrigger(trigger_id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/sections/triggers/" + $scope.trigger.section_id);
                    });
                }, 0);
            });
        }

        // Отправка формы
        $scope.submit = function() {
            var action = ($scope.trigger.id == undefined) ? 'create' : 'update';

            if (action == 'create') {

                Trigger.create($scope.trigger).then(function(result) {
                    $scope.trigger = {};
                    $scope.addAlert('Триггер успешно сохранен');
                });

            } else {
                Trigger.update($scope.trigger).then(function(result) {
                    $scope.addAlert('Триггер успешно изменен');
                });
            }
        }
    }
])