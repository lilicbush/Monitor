'use strict';
/**
 * @ngdoc overview
 * @name sbAdminApp
 * @description
 * # sbAdminApp
 *
 * Main module of the application.
 */
angular.module('sbAdminApp', [
        'oc.lazyLoad',
        'ui.router',
        'ui.bootstrap',
        'ngAnimate',
        'angular-loading-bar',
        'oi.file',
        'permission',
        'ngSanitize'
    ])
    .run(function(Permission, User, $q) {
        Permission.defineRole('observer', function(stateParams) {
            var deferrer = $q.defer();
            User.getRole().then(function(response) {

                if (response.data == 'observer') {
                    deferrer.resolve();
                } else {
                    deferrer.reject();
                }
            }, function () {
                deferrer.reject();
            })

            return deferrer.promise;
        })
    })
    .config(['$stateProvider','$urlRouterProvider','$ocLazyLoadProvider',function ($stateProvider,$urlRouterProvider,$ocLazyLoadProvider) {

        $ocLazyLoadProvider.config({
            debug:false,
            events:true
        });

        $urlRouterProvider.otherwise('/projects');

        $stateProvider
            .state('login', {
                templateUrl:'/account/template/login',
                controller: 'LoginCtrl',
                url:'/login',
                resolve: {
                    loadMyDirectives: function($ocLazyLoad) {
                        return $ocLazyLoad.load(
                            {
                                name: 'login',
                                files:['/js/controllers/LoginCtrl.js',]
                            }
                        )
                    }
                }
            })
            .state('projects', {
                url:'/projects',
                templateUrl: '/site/template/main',
                controller: 'ProjectListCtrl',
                data: {
                    permissions: {
                        only: ['observer'],
                        redirectTo: 'login'
                    }
                },
                resolve: {
                    loadMyDirectives:function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:'sbAdminApp',
                                files:[
                                    '/directives/header/header.js',
                                    '/directives/header/header-notification/header-notification.js',
                                    '/directives/sidebar/sidebar.js',
                                    '/directives/sidebar/sidebar-search/sidebar-search.js',
                                    '/js/controllers/MenuCtrl.js',
                                    '/js/controllers/ProjectEditCtrl.js',
                                    '/js/controllers/ProjectListCtrl.js',
                                    '/js/controllers/ProjectScheduleCtrl.js',
                                    '/js/controllers/SectionsListCtrl.js',
                                    '/js/controllers/UserInfoCtrl.js',
                                    '/js/controllers/TriggersAlertsCtrl.js',
                                    '/js/controllers/SearchListCtrl.js',
                                ]
                            })

                    }
                }
            })
            .state('projects.view',{
                templateUrl: '/projects/template/view',
                url:'/projects/view/:id',
                controller: 'SectionsListCtrl'
            })
            .state('projects.create',{
                templateUrl: '/projects/template/create',
                url:'/projects/add',
                controller: 'ProjectEditCtrl'
            })
            .state('projects.update',{
                templateUrl: '/projects/template/edit',
                url:'/projects/edit/:id',
                controller: 'ProjectEditCtrl'
            })
            .state('projects.search',{
                templateUrl: '/search/template/list',
                url:'/search/list/:search',
                controller: 'SearchListCtrl'
            })
            .state('projects.schedule',{
                templateUrl: '/projects/template/schedule',
                url:'/projects/schedule',
                controller: 'ProjectScheduleCtrl'
            })
            .state('sections', {
                templateUrl: '/site/template/main',
                resolve: {
                    loadMyDirectives:function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:'sbAdminApp',
                                files:[
                                    '/directives/header/header.js',
                                    '/directives/header/header-notification/header-notification.js',
                                    '/directives/sidebar/sidebar.js',
                                    '/directives/sidebar/sidebar-search/sidebar-search.js',
                                    '/js/controllers/MenuCtrl.js',
                                    '/js/controllers/SectionsListCtrl.js',
                                    '/js/controllers/SectionsEditCtrl.js',
                                    '/js/controllers/TriggersListCtrl.js',
                                    '/js/controllers/TriggersAlertsCtrl.js',
                                    '/js/controllers/UserInfoCtrl.js',
                                ]
                            })

                    }
                }
            })
            .state('sections.create',{
                templateUrl: '/sections/template/create',
                url:'/sections/add/project_id/:project_id',
                controller: 'SectionsEditCtrl'
            })
            .state('sections.update',{
                templateUrl: '/sections/template/update',
                url:'/sections/update/project_id/:project_id/section_id/:section_id',
                controller: 'SectionsEditCtrl'
            })
            .state('sections.triggers', {
                templateUrl: '/sections/template/triggers',
                url:'/sections/triggers/:section_id',
                controller: 'TriggersListCtrl'
            })
            .state('triggers', {
                templateUrl: '/site/template/main',
                resolve: {
                    loadMyDirectives:function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:'sbAdminApp',
                                files:[
                                    '/directives/header/header.js',
                                    '/directives/header/header-notification/header-notification.js',
                                    '/directives/sidebar/sidebar.js',
                                    '/directives/sidebar/sidebar-search/sidebar-search.js',
                                    '/js/controllers/MenuCtrl.js',
                                    '/js/controllers/TriggersListCtrl.js',
                                    '/js/controllers/TriggersEditCtrl.js',
                                    '/js/controllers/TriggersViewCtrl.js',
                                    '/js/controllers/TriggersAlertsCtrl.js',
                                    '/js/controllers/UserInfoCtrl.js'
                                ]
                            })

                    }
                }
            })
            .state('triggers.create', {
                templateUrl: '/triggers/template/create',
                url:'/triggers/add/section_id/:section_id',
                controller: 'TriggersEditCtrl'
            })
            .state('triggers.update', {
                templateUrl: '/triggers/template/update',
                url:'/triggers/update/section_id/:section_id/trigger_id/:trigger_id',
                controller: 'TriggersEditCtrl'
            })
            .state('triggers.view', {
                templateUrl: '/triggers/template/view',
                url:'/triggers/view/:trigger_id',
                controller: 'TriggersViewCtrl'
            })
            .state('users', {
                templateUrl: '/site/template/main',
                resolve: {
                    loadMyDirectives:function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:'sbAdminApp',
                                files:[
                                    '/directives/header/header.js',
                                    '/directives/header/header-notification/header-notification.js',
                                    '/directives/sidebar/sidebar.js',
                                    '/directives/sidebar/sidebar-search/sidebar-search.js',
                                    '/js/controllers/MenuCtrl.js',
                                    '/js/controllers/UserInfoCtrl.js',
                                    '/js/controllers/TriggersAlertsCtrl.js',
                                    '/js/controllers/UsersPasswordCtrl.js',
                                    '/js/controllers/UsersListCtrl.js',
                                    '/js/controllers/UsersEditCtrl.js'
                                ]
                            }
                        )

                    }
                }
            })
            .state('users.password', {
                templateUrl: '/account/template/password',
                url:'/account/password',
                controller: 'UsersPasswordCtrl'
            })
            .state('users.list', {
                templateUrl: '/account/template/list',
                url:'/account/list',
                controller: 'UsersListCtrl'
            })
            .state('users.create', {
                templateUrl: '/account/template/create',
                url:'/account/create',
                controller: 'UsersEditCtrl'
            })
            .state('users.update', {
                templateUrl: '/account/template/update',
                url:'/account/update/:id',
                controller: 'UsersEditCtrl'
            })
            .state('db', {
                templateUrl: '/site/template/main',
                resolve: {
                    loadMyDirectives:function($ocLazyLoad){
                        return $ocLazyLoad.load(
                            {
                                name:'sbAdminApp',
                                files:[
                                    '/directives/header/header.js',
                                    '/directives/header/header-notification/header-notification.js',
                                    '/directives/sidebar/sidebar.js',
                                    '/directives/sidebar/sidebar-search/sidebar-search.js',
                                    '/js/controllers/MenuCtrl.js',
                                    '/js/controllers/UserInfoCtrl.js',
                                    '/js/controllers/TriggersAlertsCtrl.js',
                                    '/js/controllers/DbListCtrl.js',
                                    '/js/controllers/DbEditCtrl.js'
                                ]
                            }
                        )

                    }
                }
            })
            .state('db.list', {
                templateUrl: '/databases/template/list',
                controller: 'DbListCtrl',
                url:'/databases/list'
            })
            .state('db.create', {
                templateUrl: '/databases/template/create',
                controller: 'DbEditCtrl',
                url:'/databases/create'
            })
            .state('db.update', {
                templateUrl: '/databases/template/update',
                controller: 'DbEditCtrl',
                url:'/databases/update/:db_id'
            })

    }])
    .directive('myEnter', function () {
        return function (scope, element, attrs) {
            element.bind("keydown keypress", function (event) {
                if(event.which === 13) {
                    scope.$apply(function (){
                        scope.$eval(attrs.myEnter);
                    });

                    event.preventDefault();
                }
            });
        };
    })
    .factory('User', ['$http', function($http) {
        var User = function(){}

        User.getRole = function(){
            return $http.get('/account/role');
        };

        User.auth = function(user){
            return $http.post('/account/login', {'user': user});
        }

        User.logout = function(user){
            return $http.post('/account/logout');
        }

        User.changePassword = function(old_password, new_password) {
            return $http.post('/account/password', {old: old_password, 'new': new_password});
        }

        User.getUsers = function() {
            return $http.get('/account/list');
        }

        User.create = function(user) {
            return $http.post('/account/create', {user: user});
        }

        User.update = function(user) {
            return $http.post('/account/update/' + user.id, {user: user});
        }

        User.deleteUser = function(user_id) {
            return $http.get('/account/delete/' + user_id);
        }

        User.getInfo = function(user_id) {
            return $http.get('/account/info/' + user_id);
        }

        return User;
    }])
    .factory('Project', ['$http', function($http) {
        var Project = function() {}

        Project.getProjects = function() {
            return $http.get('/projects/tree');
        }

        Project.getProject = function(params) {
            return $http.get('/projects/update', params);
        }

        Project.deleteLogo = function(params) {
            return $http.get('/projects/deletelogo', params);
        }

        Project.deleteProject = function(params) {
            return $http.get('/projects/delete', params);
        }

        Project.create = function(project) {
            return $http.post('/projects/create', {project: project});
        }

        Project.update = function(project) {
            return $http.post('/projects/update/' + project.id, {project: project});
        }

        Project.getList = function(){
            return $http.get('/projects/list');
        }

        Project.getInfo = function(id) {
            return $http.get('/projects/view', {params: {id: id}});
        }

        Project.search = function(search) {
            return $http.post('/search/list', {search: search.search});
        }

        Project.getSchedule = function() {
            return $http.get('/projects/schedule');
        }

        return Project;
    }])
    .factory('Section', ['$http', function($http) {
        var Section = function() {}

        Section.deleteSection = function(id) {
            return $http.get('/sections/delete', {params: {id: id}});
        }

        Section.getInfo = function(id) {
            return $http.get('/sections/view', {params: {id: id}});
        }

        Section.getTriggers = function(id) {
            return $http.get('/sections/triggers', {params: {id: id}});
        }

        Section.create = function(section) {
            return $http.post('/sections/create', {section: section});
        }

        Section.update = function(section) {
            return $http.post('/sections/update/' + section.id, {section: section});
        }

        Section.getList = function() {
            return $http.get('/sections/list');
        }

        Section.getForeignData = function(section_id) {
            return $http.get('/sections/info', {params: {id: section_id}});
        }

        return Section;
    }])
    .factory('Trigger', ['$http', function($http) {
        var Trigger = function(){}

        Trigger.getInfo = function(trigger_id) {
            return $http.get('/triggers/view', {params: {id: trigger_id}})
        }

        Trigger.create = function(trigger) {
            return $http.post('/triggers/create', {trigger: trigger})
        }

        Trigger.update = function(trigger) {
            return $http.post('/triggers/update/' + trigger.id, {trigger: trigger});
        }

        Trigger.getFullTriggerInfo = function(id) {
            return $http.get('/triggers/full/' + id);
        }

        Trigger.setActivity = function(id, activity) {
            return $http.post('/triggers/activity/' + id, {activity: activity});
        }

        Trigger.deleteTrigger = function (id) {
            return $http.get('/triggers/delete', {params: {id: id}})
        }

        Trigger.run = function (trigger_id) {
            return $http.get('/triggers/run/' + trigger_id);
        }

        Trigger.getLastMessages = function (id, page) {
            return $http.get('/triggers/messages/' + id + '?page=' + page);
        }

        Trigger.addObserver = function(id, observer) {
            return $http.post('/triggers/addobserver', {id: id, observer: observer});
        }

        Trigger.deleteObserver = function(id, observer) {
            return $http.post('/triggers/deleteobserver', {id: id, observer: observer});
        }

        Trigger.getAlerts = function() {
            return $http.get('/triggers/alerts');
        }

        return Trigger;
    }])
    .factory('Event', ['$http', function($http) {
        var Event = function(){}

        Event.create = function(event) {
            return $http.post('/events/create', {event: event});
        }

        Event.update = function(event) {
            return $http.post('/events/update/' + event.id, {event: event});
        }

        Event.deleteEvent = function(event_id) {
            return $http.get('/events/delete/' + event_id);
        }

        Event.setActivity = function(id, activity) {
            return $http.post('/events/activity/' + id, {activity: activity});
        }

        Event.getInfo = function(event_id) {
            return $http.get('/events/info/' + event_id);
        }

        Event.runEvent = function (event_id) {
            return $http.get('/events/run/' + event_id);
        }

        return Event;
    }])
    .factory('Database', ['$http', function($http) {
        var Database = function() {};

        Database.create = function(database) {
            return $http.post('/databases/create', {database: database});
        }

        Database.update = function(database) {
            return $http.post('/databases/update/' + database.id, {database: database});
        }

        Database.deleteDatabase = function(database_id) {
            return $http.get('/databases/delete/' + database_id);
        }

        Database.getInfo = function(database_id) {
            return $http.get('/databases/info/' + database_id);
        }

        Database.getDatabases = function() {
            return $http.get('/databases/list/');
        }

        Database.getDbms = function () {
            return $http.get('/databases/dbms');
        }

        Database.testConnect = function(database) {
            return $http.post('/databases/test', {database: database});
        }

        return Database;
    }])
    .factory('Helper', ['$http', function() {
        var Helper = function(){}

        Helper.prepareObject = function(obj) {

            for (var key in obj) {
                if (obj[key] !== undefined && obj[key] !== null && typeof obj[key] !== 'function') {
                    obj[key] = obj[key].toString();
                    console.log(obj[key]);
                }
            }

            return obj;
        }

        return Helper;
    }]);