"use strict";

angular.module('sbAdminApp').controller('UsersPasswordCtrl', ['$scope', '$http', '$location', 'User',
    function ($scope, $http, $location, User) {
        // Работа с сообщениями
        $scope.alerts = [];
        $scope.alerts_errors = [];

        $scope.addAlert = function (msg, type) {
            if (type == 'error') {
                $scope.alerts_errors.push({msg: msg});
            } else {
                $scope.alerts.push({msg: msg});
            }
        };

        $scope.cancel = function(){
            setTimeout(function () {
                $scope.$apply(function () {
                    $location.path("/#projects");
                });
            }, 0);
        }

        $scope.submit = function(){
            if ($scope.new_password != $scope.confirm_password) {
                $scope.addAlert('Пароли не совпадают', 'error');
                return false;
            }

            User.changePassword($scope.old_password, $scope.new_password).then(function(result) {
                $scope.alerts_errors = [];
                $scope.alerts = [];

                if (result.data == 'wrong_password') {
                    $scope.addAlert('Старый пароль не верный! Попробуйте еще раз.', 'error');
                } else if (result.data == 'ok') {

                    $scope.addAlert('Пароль успешно изменен', 'success');
                    $scope.old_password = $scope.new_password = $scope.confirm_password = '';
                } else {
                    $scope.addAlert('Произошла непредвиденная ошибка', 'error');
                }
            })
        }
    }]
);