'use strict'
var moduloApp = angular.module('easyQasaApp',
    [
        'ngResource',
        'ngSanitize'
    ]
    ).config(['$interpolateProvider', function ($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');

    }])
;