define(
    [
        'jquery',
        'angular',
        'appModule',
        'mainController',
        'advertsController',
        'myAdvertsController',
        'offersController',
        'advertFile',
        'offerFile',
        'errorSrc'
    ],
    function ($, angular, app, mainController, advertsController, offersController) {

        'use strict';
        app.CSRF_TOKEN =  {
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            timeout: 7000
        };

        app.config(function($routeProvider){
            $routeProvider
                .when('/',{
                    templateUrl:'js/views/home.html',
                    controller:'mainController'
                })
                    
                // ADVERTS ROUTES
                .when('/adverts',{
                    templateUrl: 'js/views/advert.all.html',
                    controller: 'advertsController'
                })
                .when('/adverts/show',{
                    templateUrl: 'js/views/advert.html',
                    controller: 'advertsController'
                })
                .when('/adverts/my',{
                    templateUrl: 'js/views/advert.all.my.html',
                    controller: 'myAdvertsController'
                })
                .when('/adverts/my/show',{
                    templateUrl: 'js/views/advert.my.offers.html',
                    controller: 'myAdvertsController'
                })
                .when('/adverts/my/edit',{
                    templateUrl: 'js/views/advert.edit.html'
                })
                .when('/adverts/add',{
                    templateUrl: 'js/views/advert.add.html'
                })
                    
                // OFFERS ROUTES
                .when('/offer/',{
                    templateUrl:'js/views/offer.html',
                    controller: 'offersController'
                })
                .when('/offers/my',{
                    templateUrl:'js/views/offer.all.html',
                    controller: 'offersController'
                })
                .when('/offers/my/show/',{
                    templateUrl:'js/views/offer.my.html',
                    controller: 'offersController'
                })
                .when('/offers/my/edit/',{
                    templateUrl:'js/views/offer.edit.html'
                })
                .when('/offers/add',{
                    templateUrl: 'js/views/offer.add.html'
                });
        });

        return angular.bootstrap(document,['app']);
    }
);