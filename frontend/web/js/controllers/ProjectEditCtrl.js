"use strict";

angular.module('sbAdminApp').controller('ProjectEditCtrl',
    ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Project',
    function ($scope, $rootScope, $http, $stateParams, $location, Project) {
        $scope.alerts = [];

        if ($stateParams.id != undefined) {
            Project.getProject({params: {id: $stateParams.id}}).then(function (result) {
                    $scope.project = result.data;
                }
            )
        } else {
            $scope.project = {};
        }

        $scope.addAlert = function (msg) {
            $scope.alerts.push({msg: msg, type: 'success'});
        };

        $scope.cancel = function () {
            setTimeout(function () {
                $scope.$apply(function () {
                    $location.path("/");
                });
            }, 0);
        }

        $scope.removeProjectLogo = function() {
            if (!confirm('Вы действительно хотите удалить логотип проекта?')) {
                return false;
            }

            if ($stateParams.id == undefined) {
                alert('На данный момент логотипа нет');
            } else {
                Project.deleteLogo({params: {id: $stateParams.id}}).then(function (result) {
                    $scope.project.logo = null;
                });
            }
        }

        $scope.options = {
            //Вызывается для каждого выбранного файла
            change: function (file) {
                $scope.errors = {};
                //В file содержится информация о файле
                //Загружаем на сервер
                file.$upload('/projects/upload', $scope.form.logo,
                    {
                        allowedType: ["jpeg", "jpg", "png"],
                        maxSize: 500000, errorBadType: 'Допустимые типы: jpeg, jpg, png',
                        errorBigSize: 'Вес не более 500K'
                    }).then(
                        function (data) {
                            $scope.project.logo = JSON.parse(data.response).filename;
                            console.log('upload success', data)
                        },
                        function (data) {
                            console.log('upload error', data);
                        },
                        function (data) {
                            console.log('upload notify', data)
                        }
                    );
            }
        };

        $scope.submit = function () {
            var action = ($scope.project.id == undefined) ? 'create' : 'update';

            if (action == 'create') {
                Project.create($scope.project).then(function(){
                    $scope.project = {};
                    $scope.$parent.addAlert('Проект успешно сохранен');
                    $rootScope.$broadcast('getProjects');
                });
            } else {
                Project.update($scope.project).then(function(){
                    $scope.project = {};
                    $scope.$parent.addAlert('Проект успешно изменен');
                    $rootScope.$broadcast('getProjects');
                });
            }
        }
    }]);