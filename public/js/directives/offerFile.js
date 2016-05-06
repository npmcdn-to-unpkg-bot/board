define(
    [
        'jquery',
        'angular',
        'appModule',
        'expansions'
    ],
    function ($, angular, app) {
        'use strict';
        return app.directive('offerModel',['$parse',function ($parse) {
            return {
                restrict: 'A',
                link: function (scope, element, attrs) {
                    var model = $parse(attrs.offerModel);
                    var modelSetter = model.assign;

                    element.bind('change',function () {
                        scope.$apply(function(){
                            modelSetter(scope, element[0].files[0]);
                        });
                        //
                        app.expansions.convertToBase64(scope.offerFile,function(image){
                            if(scope.offer){
                                scope.offer.image = image;
                            } else {
                                scope.offer = {
                                    image: image
                                };
                            }
                            //
                            $("[data-app='preview']").prop('src',image);
                        });
                    })
                }
            }
        }]);
    }
);