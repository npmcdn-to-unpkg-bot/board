define(
    [
        'jquery',
        'angular',
        'appModule',
        'expansions'
    ],
    function ($, angular, app) {
        'use strict';
        return app.directive('advertModel',['$parse',function ($parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    var model = $parse(attrs.advertModel);
                    var modelSetter = model.assign;

                    element.bind('change',function () {
                        scope.$apply(function(){
                            modelSetter(scope, element[0].files[0]);
                        });
                        //
                        app.expansions.convertToBase64(scope.advertFile,function(image){
                            $("[data-app='preview']").prop('src',image);
                            if(scope.advert){
                                scope.advert.image = image;
                            } else {
                                scope.advert = {
                                    image: image
                                };
                            }
                        });
                    })
                }
            }
        }]);
    }
);