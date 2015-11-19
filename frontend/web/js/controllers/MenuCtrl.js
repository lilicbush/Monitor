"use strict";

angular.module('sbAdminApp').controller('MenuCtrl', ['$scope', '$http', 'Project',
    function ($scope, $http, Project) {

        $scope.$on('getProjects', function (){
            Project.getProjects().then(function (result) {
                    $scope.projects = result.data;
                }
            )
        });

        $scope.$emit('getProjects');
    }]);