"use strict";

angular.module('sbAdminApp').controller('DbEditCtrl', ['$scope', '$http', '$stateParams', '$location', 'Database', 'Helper',
    function ($scope, $http, $stateParams, $location, Database, Helper) {
        $scope.database = {};

        $scope.alerts = [];

        $scope.addAlert = function (msg) {
            $scope.alerts.push({msg: msg, type: 'success'});
        };

        Database.getDbms().then(function(result){
            $scope.dbms = result.data;
        })

        if ($stateParams.db_id != undefined) {
            Database.getInfo($stateParams.db_id).then(function(result) {
                $scope.database = Helper.prepareObject(result.data);
            })
        }

        $scope.deleteDatabase = function (db_id) {
            if (!confirm('Вы действительно хотите удалить запись об этой базе данных?')) {
                return false;
            }

            Database.deleteDatabase(db_id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/databases/list");
                    });
                }, 0);
            });
        }

        $scope.testConnect = function() {
            Database.testConnect($scope.database).then(function(result) {
                if (result.data.result == 'success') {
                    alert('База данных к работе готова');
                } else {
                    alert('Ошибка подключения к БД - ' + result.data.error);
                }
            });
        }

        $scope.submit = function() {
            var action = ($scope.database.id == undefined) ? 'create' : 'update';

            if (action == 'create') {
                Database.create($scope.database).then(function(){
                    $scope.addAlert('База данных успешно добавлена');
                    $scope.database = {};
                });
            } else {
                Database.update($scope.database).then(function(){
                    $scope.addAlert('База данных успешно изменена');
                });
            }
        }
    }
]);