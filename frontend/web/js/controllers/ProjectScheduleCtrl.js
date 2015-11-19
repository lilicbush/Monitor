"use strict";

angular.module('sbAdminApp').controller('ProjectScheduleCtrl', ['$scope', '$http', '$stateParams', 'Project',
    function ($scope, $http, $stateParams, Project) {

        function getSchedule() {
            Project.getSchedule().then(function(result){
                $scope.schedule = result.data;
            });
        }

        getSchedule();
        setInterval(getSchedule,5000);
    }]);