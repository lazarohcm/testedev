'use strict';

/* Controllers */
var app = angular.module('easyqasa.controllers.product', []);

app.controller('indexProductController',
	['$scope', '$http', function ($scope, $http) {


	$scope.index = function(){
        var url = Routing.generate('api_rest_product_list');

        $http.get(url)
        .then(
            function(resposta) {
            	$scope.products = resposta.data.products;
            }
        );
	}

	$scope.cadastro = function()
	{
        var rota = Routing.generate('product_create');
        location.href = rota;
	}

	$scope.editar = function(id)
	{
        var rota = Routing.generate('product_edit');
        location.href = rota+'/'+id;
	}

	$scope.excluir = function(id){
        var url = Routing.generate('api_rest_product_delete', {id:id});

        $http.delete(url)
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Produto excluído com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('product_index');
					        location.href = rota;
            			}
            		);
            	}else{
                    swal(
                        "Ops!",
                        resposta.data.error,
                        "error");
            	}
            }
        );
	}

}])
app.controller('cadastroProductController',
	['$scope', '$http', function ($scope, $http) {

	$scope.usuario = {};

	$scope.cadastrar = function(){
        var url = Routing.generate('api_rest_product_create');

        $http.post(url, {product: $scope.product})
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Produto cadastrado com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('product_index');
					        location.href = rota;
            			}
            		);
            	}else{
                    swal(
                        "Ops!",
                        resposta.data.error,
                        "error");
            	}
            }
        );
	}

}])
app.controller('editarProductController',
	['$scope', '$http', function ($scope, $http) {

	$scope.index = function(id){
        var url = Routing.generate('api_rest_product_find_by_id', {id:id});

        $http.get(url)
        .then(
            function(resposta) {
            	$scope.product = resposta.data.product;
            }
        );
	}
	$scope.editar = function(){
        var url = Routing.generate('api_rest_product_update');

        $http.put(url, {product: $scope.product})
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Edição realizada com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('product_index');
					        location.href = rota;
            			}
            		);
            	}else{
                    swal(
                        "Ops!",
                        resposta.data.error,
                        "error");
            	}
            }
        );
	}

}])
;

angular.module('easyQasaApp').requires.push('easyqasa.controllers.product');
