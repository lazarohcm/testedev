'use strict';
angular.module('easyqasa.product.factory', [])
    .factory( 'productService', ['$resource', '$http', function($resource, $http) {
        return new Product($resource);

        function Product(resource) {
            this.resource = resource;

        }
    }])
;


angular.module('easyQasaApp').requires.push('easyqasa.product.factory');
