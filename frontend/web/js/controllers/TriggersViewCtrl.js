"use strict";

angular.module('sbAdminApp').controller('TriggersViewCtrl',
    ['$scope', '$rootScope', '$http', '$stateParams', '$location', 'Trigger', 'Event', 'Helper',
    function($scope, $rootScope, $http, $stateParams, $location, Trigger, Event, Helper) {

        $scope.event_activities = {};
        $scope.loading_trigger = false;
        $scope.last_messages = [];
        $scope.current_page = 1;
        $scope.show_add_observer = false;

        // Отображение данных по триггеру
        var getTriggerInfo = function () {
            Trigger.getFullTriggerInfo($stateParams.trigger_id).then(function(result){
                $scope.trigger = result.data.trigger;
                angular.extend($scope.trigger, result.data.trigger_info)
                console.log($scope.trigger.expressions);
                $scope.activity = $scope.trigger.is_active;

                $scope.trigger.events.forEach(function(event) {
                    $scope.event_activities[event.id] = event.is_show;
                });

                $scope.getLastMessages($scope.trigger.id, $scope.current_page);
            });
        };

        getTriggerInfo();

        $scope.deleteTrigger = function (trigger_id) {
            if (!confirm('Вы действительно хотите удалить триггер и все его данные?')) {
                return false;
            }

            Trigger.deleteTrigger(trigger_id).then(function (result) {
                setTimeout(function () {
                    $scope.$apply(function () {
                        $location.path("/sections/triggers/" + $scope.trigger.section_id);
                    });
                }, 0);
            });
        }

        $scope.addObserver = function(){
            Trigger.addObserver($scope.trigger.id, $scope.new_observer).then(function(result) {
                if (result.data == 'exist') {
                    alert('Данный E-Mail уже является наблюдателем этого триггера');
                } else if(result.data == 'error') {
                    alert('Произошла непредвиденная ошибка');
                } else {
                    $scope.show_add_observer = false;
                    $scope.new_observer = '';
                    getTriggerInfo();
                }
            });
        }

        $scope.deleteObserver = function(observer) {
            Trigger.deleteObserver($scope.trigger.id, observer).then(function() {
                getTriggerInfo();
            })
        }

        $scope.setActivity = function(){
            Trigger.setActivity($scope.trigger.id, $scope.activity);
        }

        $scope.setEventActivity = function(event_id) {
            Event.setActivity(event_id, $scope.event_activities[event_id]);
        }

        $scope.updateEvent = function(event) {
            $scope.event = event;
            if (!($scope.event.time_to_start instanceof Date)) {
                var time_arr = event.time_to_start.split(':');
                var event_date = new Date(1970, 0, 1, time_arr[0], time_arr[1], time_arr[2]);
                $scope.event.time_to_start = event_date
            }

            $scope.event.compare_exp = event.compare_exp.toString();
            $scope.show_add_event_form = true;
        }

        $scope.cancelAddEvent = function() {
            $scope.show_add_event_form = false;
            $scope.event = {}
        }

        $scope.deleteEvent = function(event_id) {
            if (!confirm('Вы действительно хотите удалить данное событие и все его данные?')) {
                return false;
            }

            Event.deleteEvent(event_id).then(function(){
                getTriggerInfo();
            })
        }

        function intervalTrigger() {
            return window.setInterval( function() {
                $scope.loading_trigger = true;
            }, 300 );
        }

        $scope.run = function() {
            var interval_id = intervalTrigger();

            Trigger.run($scope.trigger.id).then(function(result) {
                getTriggerInfo();
                clearInterval(interval_id);
                $scope.current_page = 1;
                $scope.last_messages = [];
                $scope.getLastMessages($scope.trigger.id, $scope.current_page);
                $scope.loading_trigger = false;
            });
        }

        $scope.runEvent = function(event_id) {
            var interval_id = intervalTrigger();

            Event.runEvent(event_id).then(function() {
                getTriggerInfo();
                clearInterval(interval_id);
                $scope.loading_trigger = false;
                $rootScope.$broadcast('getAlerts');
            });
        }

        $scope.getLastMessages = function($trigger_id, page) {
            Trigger.getLastMessages($trigger_id, page).then(function(result){
                $scope.last_messages = $scope.last_messages.concat(result.data);
                $scope.current_page++;
            });
        }

        $('[data-toggle="popover"]').popover()

        $scope.submit = function() {

            var action = ($scope.event.id == undefined) ? 'create' : 'update';

            if (action == 'create') {
                $scope.event.trigger_id = parseInt($scope.trigger.id);
                Event.create($scope.event).then(function(){
                    $scope.show_add_event_form = 0;
                });
            } else {
                Event.update($scope.event).then(function(){
                    $scope.show_add_event_form = 0;
                    $scope.event = {}
                });
            }

            getTriggerInfo();
        }

    }
]);