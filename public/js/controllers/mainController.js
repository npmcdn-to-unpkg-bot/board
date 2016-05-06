define(['angular','appModule'],function(angular, app){
    return app.controller('mainController',function($scope){
        $scope.message = 'Home page message';
    });
});