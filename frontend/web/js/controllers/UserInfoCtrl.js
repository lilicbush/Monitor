"use strict";

angular.module('sbAdminApp').controller('UserInfoCtrl', ['$scope', '$http', '$location', 'User',
    function ($scope, $http, $location, User) {

        $scope.logout = function(){
            User.logout().then(function(result){
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("#/login");
                    });
                }, 0);
            })
        }

    }]
);