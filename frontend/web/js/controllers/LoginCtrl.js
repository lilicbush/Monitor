"use strict";

angular.module('sbAdminApp').controller('LoginCtrl', ['$scope', '$http', '$location', 'User',
    function($scope, $http, $location, User) {
        $scope.user = {};
        User.getRole().then(function(response) {});

        // Отправка формы
        $scope.submit = function() {
            User.auth($scope.user).then(function(result) {
                if (result.data == 'error') {
                    alert('Логин или пароль не верный!');
                } else {
                    setTimeout(function () {
                        $scope.$apply(function () {
                            $location.path("/");
                        });
                    }, 0);
                }
            });
        }
    }]
)