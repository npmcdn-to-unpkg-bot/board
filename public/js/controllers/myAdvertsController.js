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

        return app.controller('myAdvertsController',function($scope, $http, $routeParams) {

            $scope.params = $routeParams;

            $scope.myAdvertsMethods = {
                all: function(){
                    $http.get('/api/advert/my',app.CSRF_TOKEN).success(function(response){
                        $scope.adverts = response;
                    });
                },
                getById:function(id){
                    $http.get('/api/advert' + '/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.adverts = response;
                    });
                },
                removeById: function(id){
                    $http.delete('/api/advert' + '/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.adverts = response;
                        location.replace('#adverts/my');
                    });
                },
                editAdvert:function(){
                    var id = this.id,
                        data = $scope.advert,
                        form  = $('[data-advert="form"]'),
                        n = app.expansions.backLight(form);

                    n.indicator();
                    $http.post('/api/advert'+'/'+id,data,app.CSRF_TOKEN).success(function(response){
                        var check = app.expansions.checkResult(response);
                        if(check === true) {
                            $scope.advert = response[0];
                            n.show(check,'success',function () {
                                location.replace('#adverts/my/show?do=get&id='+id+'&offers=true');
                            });
                        } else {
                            n.show(check,'errors');
                        }
                    });
                },
                editAdvertById:function(id){
                    this.id = id;
                    $http.get('/api/advert' + '/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.advert = response[0];
                    });
                },
                addAdvert:function(){
                    var data = $scope.advert,
                        form  = $('[data-advert="form"]'),
                        n = app.expansions.backLight(form);

                    n.indicator();

                    $http.put('/api/advert',data,app.CSRF_TOKEN).success(function (response) {
                        var check = app.expansions.checkResult(response);
                        $scope.adverts = response;
                        if(check === true) {
                            n.show(check,'success',function(){
                                location.replace('#adverts/my');
                            });
                        } else {
                            n.show(check,'errors');
                        }
                    });
                },
                getWithOffers: function (id) {
                    $http.get('/api/advert/'+id+'/offers',app.CSRF_TOKEN).success(function (response) {
                        $scope.advert = response.advert[0];
                        $scope.offers = response.offers;
                    });
                }
            };

            if(Object.keys($scope.params).length > 0){
                if($scope.params.do){
                    switch ($scope.params.do)
                    {
                        case "get":
                            if($scope.params.id && $scope.params.id > 0){
                                if ($scope.params.offers == 'true') {
                                    $scope.myAdvertsMethods.getWithOffers($scope.params.id)
                                } else {
                                    $scope.myAdvertsMethods.getById($scope.params.id);
                                }
                            }
                            break;
                        case "remove":
                            if($scope.params.id && $scope.params.id > 0){
                                $scope.myAdvertsMethods.removeById($scope.params.id);
                            }
                            break;
                        case "edit":
                            if($scope.params.id && $scope.params.id > 0){
                                $scope.myAdvertsMethods.editAdvertById($scope.params.id);
                            }
                            break;
                        default:
                            $scope.myAdvertsMethods.all();
                    }
                } else {
                    $scope.myAdvertsMethods.all();
                }
            } else {
                $scope.myAdvertsMethods.all();
            }
        });
    }
);