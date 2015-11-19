"use strict";

angular.module('sbAdminApp').controller('ProjectListCtrl', ['$scope', '$http', 'Project',
    function ($scope, $http, Project) {
        Project.getProjects().then(function (result) {
                $scope.projects = result.data;
            }
        )
    }]);