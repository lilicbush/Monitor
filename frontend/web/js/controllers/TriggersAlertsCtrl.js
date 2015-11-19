"use strict";

angular.module('sbAdminApp').controller('TriggersAlertsCtrl', ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Trigger',
    function($scope, $rootScope, $http, $stateParams, $location, Trigger) {
        $scope.$on('getAlerts', function (){
            Trigger.getAlerts().then(function(result) {
                $scope.triggers_alerts = result.data;
            });
        });

        $scope.$emit('getAlerts');
    }
]);