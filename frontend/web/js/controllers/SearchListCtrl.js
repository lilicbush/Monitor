"use strict";

angular.module('sbAdminApp').controller('SearchListCtrl', ['$scope', '$http', '$stateParams', 'Project',
    function ($scope, $http, $stateParams, Project) {
        $scope.search = $stateParams.search;

        $scope.result = {};

        Project.search({search: $scope.search}).then(function(result){
            $scope.result = result.data;
        });
    }]);