"use strict";

angular.module('sbAdminApp').controller('SectionsEditCtrl',
    ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Project', 'Section', 'Helper',
    function ($scope, $rootScope, $http, $stateParams, $location, Project, Section, Helper) {

        if ($stateParams.project_id == undefined) {
            alert('Для редактирования разделов необходим активный проект');
            return false;
        }

        // Список проектов для поля выбора проекта
        Project.getList().then(function (result) {
                $scope.projects = result.data;
            }
        );

        // Данные о текущем проекте
        Project.getInfo($stateParams.project_id).then(function (result) {
                $scope.project = result.data;
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
                    $location.path("/projects/projects/view/" + $scope.project.id);
                });
            }, 0);
        }

        // Функция используется для создания и редактирования, если создаем новый раздел то на начальном этапе у нас известен только project_id
        if ($stateParams.section_id != undefined) {

            // Извлекаем информацию о разделе при редактировании
            Section.getInfo($stateParams.section_id).then(function (result) {
                    $scope.section = Helper.prepareObject(result.data);
                }
            )
        } else {
            $scope.section = {project_id: $stateParams.project_id.toString()}
        }

        // Отправка формы
        $scope.submit = function() {
            var action = ($scope.section.id == undefined) ? 'create' : 'update';

            if (action == 'create') {
                Section.create($scope.section).then(function(result) {
                    $scope.$parent.addAlert('Раздел успешно сохранен');
                });
            } else {
                Section.update($scope.section).then(function(result) {
                    $scope.$parent.addAlert('Раздел успешно изменен');
                });
            }
        }

        $scope.deleteSection = function (section_id) {
            if (!confirm('Вы действительно хотите удалить раздел и все его данные?')) {
                return false;
            }

            Section.deleteSection(section_id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/projects/projects/view/" + $scope.project.id);
                    });
                }, 0);
            });
        }
    }]);