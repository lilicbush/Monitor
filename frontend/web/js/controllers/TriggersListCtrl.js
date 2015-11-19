"use strict";

angular.module('sbAdminApp').controller('TriggersListCtrl', ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Section',
    function($scope, $rootScope, $http, $stateParams, $location, Section) {

        var getSection = function () {
            Section.getTriggers($stateParams.section_id).then(function (result) {
                    $scope.section = result.data;
                }
            )
        }

        getSection();

        $scope.deleteTrigger = function (trigger_id) {
            if (!confirm('Вы действительно хотите удалить триггер и все его данные?')) {
                return false;
            }

            $http.get('/triggers/delete', {params: {id: trigger_id}}).then(function (result) {
                getSection();
            });
        }

        $scope.deleteSection = function (section_id) {
            if (!confirm('Вы действительно хотите удалить раздел и все его данные?')) {
                return false;
            }

            Section.deleteSection(section_id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/projects/projects/view/" + $scope.section.project_id);
                    });
                }, 0);
            });
        }

    }
]);