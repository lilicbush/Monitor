"use strict";

angular.module('sbAdminApp').controller('DbListCtrl', ['$scope', '$http', '$location', 'Database',
    function ($scope, $http, $location, Database) {
        $scope.deleteDatabase = function (db_id) {
            if (!confirm('Вы действительно хотите удалить запись об этой базе данных?')) {
                return false;
            }

            Database.deleteDatabase(db_id).then(function (result) {
                getDatabases();
            });
        }

        var getDatabases = function (){
            Database.getDatabases().then(function(result){
                $scope.databases = result.data;
            })
        }

        getDatabases();
    }
]);