"use strict";

angular.module('sbAdminApp').controller('SectionsListCtrl', ['$scope', '$http', '$stateParams', '$rootScope', '$location', 'Project', 'Section',
    function ($scope, $http, $stateParams, $rootScope, $location, Project, Section) {
        var getProject = function () {
            Project.getInfo($stateParams.id).then(function (result) {
                    $scope.project = result.data;
                }
            )
        }

        getProject();

        $scope.deleteProject = function() {
            if (!confirm('Вы действительно хотите удалить проект и все его данные?')) {
                return false;
            }

            if ($stateParams.id == undefined) {
                alert('Нет активного проекта! Удаление невозможно.');
                return false;
            }

            Project.deleteProject({params: {id: $stateParams.id}}).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $rootScope.$broadcast('getProjects');
                        $location.path("#/projects");
                    });
                }, 0);
            });
        }

        $scope.deleteSection = function (section_id) {
            if (!confirm('Вы действительно хотите удалить раздел и все его данные?')) {
                return false;
            }

            Section.deleteSection(section_id).then(function (result) {
                getProject();
            });
        }
    }]
);