'use strict';

/* Controllers */
var app = angular.module('easyqasa.controllers.usuario', []);

app.controller('indexUsuarioController',
	['$scope', '$http', function ($scope, $http) {


	$scope.index = function(){
        var url = Routing.generate('api_rest_usuario_listagem');

        $http.get(url)
        .then(
            function(resposta) {
            	$scope.usuarios = resposta.data.usuarios;
            }
        );
	}

	$scope.cadastro = function()
	{
        var rota = Routing.generate('usuario_cadastro');
        location.href = rota;
	}

	$scope.editar = function(id)
	{
        var rota = Routing.generate('usuario_editar');
        location.href = rota+'/'+id;
	}

	$scope.excluir = function(id){
        var url = Routing.generate('api_rest_usuario_deletar', {id:id});

        $http.delete(url)
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Usuário excluído com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('usuario_index');
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
app.controller('cadastroUsuarioController',
	['$scope', '$http', function ($scope, $http) {

	$scope.usuario = {};

	$scope.cadastrar = function(){
        var url = Routing.generate('api_rest_usuario_cadastrar');

        $http.post(url, {usuario: $scope.usuario})
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Cadastro realizado com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('usuario_index');
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
app.controller('editarUsuarioController',
	['$scope', '$http', function ($scope, $http) {

	$scope.index = function(id){
        var url = Routing.generate('api_rest_usuario_busca_id', {id:id});

        $http.get(url)
        .then(
            function(resposta) {
            	$scope.usuario = resposta.data.usuario;
            }
        );
	}
	$scope.editar = function(){
        var url = Routing.generate('api_rest_usuario_editar');

        $http.put(url, {usuario: $scope.usuario})
        .then(
            function(resposta) {
            	if (resposta.status == 200){
            		swal(
                        "Sucesso!",
                        "Edição realizada com sucesso!",
                        "success")
            		.then(
            			function(){
					        var rota = Routing.generate('usuario_index');
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

angular.module('easyQasaApp').requires.push('easyqasa.controllers.usuario');
