"use strict";

angular.module('sbAdminApp').controller('UsersEditCtrl', ['$scope', '$http', '$stateParams', '$location', 'User',
    function ($scope, $http, $stateParams, $location, User) {
        $scope.user = {};

        $scope.alerts = [];

        $scope.addAlert = function (msg) {
            $scope.alerts.push({msg: msg, type: 'success'});
        };

        if ($stateParams.id != undefined) {
            User.getInfo($stateParams.id).then(function(result) {
                $scope.user = result.data;
            })
        }

        $scope.deleteUser = function (id) {
            if (!confirm('Вы действительно хотите удалить данного пользователя?')) {
                return false;
            }

            User.deleteUser(id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/account/list");
                    });
                }, 0);
            });
        }

        if ($scope.user.id == undefined) {
            $scope.change_password = true;
        }

        $scope.submit = function() {

            if ($scope.user.password != $scope.user.confirm_password) {
                alert('Пароли должны совпадать!');
                return false;
            }

            var action = ($scope.user.id == undefined) ? 'create' : 'update';

            if (action == 'create') {
                User.create($scope.user).then(function(){
                    $scope.addAlert('Пользователь успешно добавлен');
                    $scope.user = {};
                });
            } else {
                User.update($scope.user).then(function(){
                    $scope.addAlert('Пользователь успешно изменен');
                });
            }
        }
    }
]);