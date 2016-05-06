define(
    [
        'angular',
        'appModule'
    ],
    function(angular, app){

        'use strict';

        return app.controller('offersController',function($scope, $http, $routeParams){

            $scope.params = $routeParams;

            $scope.offersMethods = {
                getAll: function () {
                    $http.get('/api/offer',app.CSRF_TOKEN).success(function(response){
                        $scope.offers = response;
                    });
                },
                getItem: function (id) {
                    $http.get('/api/offer'+'/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.offers = response[0];
                    });
                },
                removeById: function(id){
                    $http.delete('/api/offer' + '/'+id,app.CSRF_TOKEN).success(function(response){
                        $scope.offers = response;
                        location.replace('#/offers/my');
                    });
                },
                editItem: function () {
                    var id = $scope.params.id,
                        data = $scope.offers,
                        form = $('[data-offer="form"]'),
                        n = app.expansions.backLight(form);

                    n.indicator();

                    if ($scope.offer) {
                        if ($scope.offer.image != null) {
                            if (typeof $scope.offer.image != 'undefined' && $scope.offer.image.length > 32) {
                                data.image = $scope.offer.image;
                            }
                        }
                    } else {
                        delete data.image;
                    }
                    $http.post('/api/offer/'+id,data,app.CSRF_TOKEN).success(function(response){
                        var check = app.expansions.checkResult(response);
                        if(check === true) {
                            $scope.offers = response[0];
                            n.show(check,'success',function () {
                                location.replace('#/offers/my/show/?do=get&id='+id);
                            });
                        } else {
                            n.show(check,'errors');
                        }
                    });
                },
                addItem: function () {
                    var id = $scope.params.id,
                        data = $scope.offer,
                        form = $('[data-offer="form"]'),
                        n = app.expansions.backLight(form);

                    n.indicator();
                    data.adv_id = id;
                    $http.put('api/offer/'+id, data,app.CSRF_TOKEN).success(function (response) {
                        var check = app.expansions.checkResult(response);

                        if(check === true) {
                            n.show(check,'success',function () {
                                location.replace('#offers/my');
                            });
                        } else {
                            n.show(check,'errors');
                        }
                    });
                },
                acceptItem: function (id) {
                    $http.post('api/offer/'+id+'/status',{"status":"accepted"},function (response) {
                        $scope.offers = response[0];
                        location.replace('#offer/?do=get&id='+id);
                    });
                }
            };

            if(Object.keys($scope.params).length > 0){
                if($scope.params.do){
                    switch ($scope.params.do)
                    {
                        case "get":
                            if($scope.params.id && $scope.params.id > 0){
                                $scope.offersMethods.getItem($scope.params.id);
                            }
                            break;
                        case "accept":
                            if($scope.params.id && $scope.params.id > 0){
                                $scope.offersMethods.acceptItem($scope.params.id);
                            }
                            break;
                        case "remove":
                            if($scope.params.id && $scope.params.id > 0){
                                $scope.offersMethods.removeById($scope.params.id);
                            }
                            break;
                        default:
                            $scope.offersMethods.getAll();
                    }
                } else {
                    $scope.offersMethods.getAll();
                }
            } else {
                $scope.offersMethods.getAll();
            }
            //
        });
    }
);