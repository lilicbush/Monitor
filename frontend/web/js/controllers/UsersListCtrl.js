"use strict";

angular.module('sbAdminApp').controller('UsersListCtrl', ['$scope', '$http', '$location', 'User',
    function ($scope, $http, $location, User) {

        var getUsers = function(){
            User.getUsers().then(function(result){
                $scope.users = result.data;
            })
        }

        getUsers();

        $scope.deleteUser = function (id) {
            if (!confirm('Вы действительно хотите удалить данного пользователя?')) {
                return false;
            }

            User.deleteUser(id).then(function () {
                getUsers()
            });
        }
    }
]);