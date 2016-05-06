/**
 *
 */
define(
    [
        'angular',
        'appModule'
    ],
    function(angular, app){

        'use strict';

        return app.controller('advertsController',function($scope, $http, $routeParams) {

            $scope.params = $routeParams;

            $scope.advertsMethods = {
                all: function(){
                    $http.get('/api/advert',app.CSRF_TOKEN).success(function(response){
                        $scope.adverts = response;
                    });
                },
                getById:function(id){
                    $http.get('/api/advert' + '/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.adverts = response;
                    });
                }
            };

            if(Object.keys($scope.params).length > 0 && $scope.params.id) {
                $scope.advertsMethods.getById($scope.params.id);
            } else {
                $scope.advertsMethods.all();
            }
        });
    }
);