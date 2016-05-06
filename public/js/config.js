/**
 * configure RequireJS
 * prefer named modules to long paths, especially for version mgt
 * or 3rd party libraries
 */

require.config({
    urlArgs: "myparam=" + (new Date()).getTime(),
    paths:
    {
        "jquery"    : "vendors/jquery/jquery-2.1.4.min",
        "bootstrap" : "vendors/bootstrap/js/bootstrap.min",
        "angular"   : "vendors/angular/angular",
        "ngRoute"   : "vendors/angular/angular-route",

        // controllers
        "mainController"    :"./controllers/mainController",
        "advertsController" :"./controllers/advertsController",
        "myAdvertsController": "./controllers/myAdvertsController",
        "offersController"  :"./controllers/offersController",
        
        // directives
        "advertFile"        :"./directives/advertFile",
        "offerFile"         : "./directives/offerFile",
        "errorSrc"          : "./directives/errorSrc",
        
        // expansions
        "expansions"        :"./expansions/exp.directives"
    },

    shim: {
        jquery: {
            exports: '$'
        },
        bootstrap: {
            deps: ['jquery']
        },
        angular: {
            exports: 'angular',
            deps: ['bootstrap']
        },
        ngRoute: {
            exports: 'ngRoute',
            deps: ['angular']
        }
    },

    deps: [
        './app'
    ]
});