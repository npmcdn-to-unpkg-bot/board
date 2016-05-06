define(
    [
        'jquery',
        'angular',
        'appModule',
        'expansions'
    ],
    function ($, angular, app) {
        'use strict';
        return app.directive('errSrc', function() {
            return {
                link: function(scope, element, attrs) {

                    scope.$watch(function() {
                        return attrs['ngSrc'];
                    }, function (value) {
                        if (!value) {
                            element.attr('src', attrs.errSrc);
                        }
                    });

                    element.bind('error', function() {
                        element.attr('src', attrs.errSrc);
                    });
                }
            }
        });
    }
);