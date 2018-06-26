 'use strict';
angular.module('easyqasa.usuario.factory', [])
.factory( 'usuarioService', ['$resource', '$http', function($resource, $http) {
	return new Usuario($resource);

	function Usuario(resource) {
		this.resource = resource;
		this.createUser = function (user, scope) {
		    var urlSave = Routing.generate('api_rest_usuario_cadastro');
			var usuario = resource(urlSave);
			usuario.save({usuario: user},
				function(response) {
		        	var rota = Routing.generate('usuario_logar_automaticamente', {email:response.usuario.email, token: 's1st3m4226521'});
		        	location.href = rota;
				}
			);
		}

		this.preCadastroProfissional = function (user, scope) {
		    var urlSave = Routing.generate('api_rest_usuario_pre_cadastro');
			var usuario = resource(urlSave);
			usuario.save({usuario: user},
				function(response) {
                    swal(
                        "Cadastro realizado!",
                        "A eQ! agradece o seu interesse, passamos pelo primeiro passo, agora aguarde nosso contato por e-mail ;)",
                        "success")
                    .then(
                        function () {
				        	var rota = Routing.generate('usuario_logar_automaticamente', {email:response.usuario.email, token: 's1st3m4226521'});
				        	location.href = rota;
						}
                    );
				},function(response){
                    swal(
                        "Ops, não deu certo!",
                        "Tente novamente, se o erro persistir entre em contato conosco!",
                        "error");
				}
			);
		}

		this.criarUsuarioCheckout = function (user, scope) {
		    var urlSave = Routing.generate('api_rest_usuario_cadastro_checkout');
			var usuario = resource(urlSave);
				usuario.save({usuario: user, orcamento_id: scope.orcamento.id}, function(response) {
					if (angular.isDefined(response.usuario)) {
						var assTipo = response.assinaturaTipoId;
				        if (assTipo == 4) {
				            var rota = Routing.generate('cliente_checkout_servico_unico');
				            location.href = rota;
				        }

				        if (assTipo == 1) {
				            var rota = Routing.generate('cliente_checkout_servicos_avulsos');
				            location.href = rota;
				        }

				        if (assTipo == 2) {
				            var rota = Routing.generate('cliente_checkout_assinatura_semanal');
				            location.href = rota;
				        }

				        if (assTipo == 3) {
				            var rota = Routing.generate('cliente_checkout_assinatura_quinzenal');
				            location.href = rota;
				        }
	        		} else {
	        			alertify.alert('Ops!', 'Infelizmente não conseguimos completar o seu cadastro, por favor tente novamente ou entre em contato conosco!');
	        		}
				});
		}

		this.findUsuario = function (id, scope ) {
			var UrlFind = Routing.generate('api_rest_usuario_find_id', {id:id});
			var Usuario = resource(UrlFind);
			Usuario.get(function(response)
				{
					scope.usuario = response.usuario;
				}
			);
		}

		this.buscaDadosPessoa = function (pessoaId, scope ) {
			var UrlFind = Routing.generate('api_rest_pessoa_find_id', {id:pessoaId});
			var Usuario = resource(UrlFind);
			Usuario.get(function(response)
				{
					scope.usuario.fnPessoa = response.pessoa;
				}
			);
		}

		this.buscarDadosForm = function (scope) {
			var UrlFind = Routing.generate('api_rest_usuario_get_dados_form');
			var Usuario = resource(UrlFind);
			Usuario.get(function(response)
				{
					scope.contatosTipo = response.contatosTipo;
					scope.enderecosTipo = response.enderecosTipo;
				}
			);
		}

		this.getEnderecoPorCep = function(cep, scope){
			var urlEndereco = 'https://viacep.com.br/ws/' + cep + '/json/';
			var Usuario = resource(urlEndereco);
			Usuario.get(function(response){
				var numero = '';
				var complemento = '';
				if (angular.isDefined(scope.orcamento.fsNumero)){
					var numero = scope.orcamento.fsNumero;
				}
				if (angular.isDefined(scope.orcamento.fsComplemento)){
					var complemento = scope.orcamento.fsComplemento;
				}
				if (!response.erro) {
					scope.endereco = {
						fnCep: response.cep,
						fsEndereco: response.logradouro,
						fsBairro: response.bairro,
						fsCidade: response.localidade,
						fsUf: response.uf,
						fsNumero: numero,
						fsComplemento: complemento
					};
				}
			});
		}

		this.findUsuarioForm = function (id, scope ) {
			var UrlFind = Routing.generate('api_rest_usuario_find_id_form', {id:id});
			var Usuario = resource(UrlFind);
			Usuario.get(function(response){
					scope.usuario = response.usuario;
				}
			);
		}

		this.buscaClientePerfil = function (id, scope ) {
			var UrlFind = Routing.generate('api_rest_usuario_cliente_id', {id:id});
			var Usuario = resource(UrlFind);
			Usuario.get(function(response){
					scope.usuario = response.usuario;
				}
			);
		}

		this.findUsuarioActive = function (scope) {
			var UrlFind = Routing.generate('api_rest_usuario_get_user_active');
			var Usuario = resource(UrlFind);
			Usuario.get(function(response){
					scope.usuario = response.usuario;
				}
			);
		}

		this.getClientesAutocomplete = function (string, scope) {
		    var urlBusca = Routing.generate('api_rest_usuario_get_cliente_autocomplete', {string:string});
			var Usuarios = resource(urlBusca);
			Usuarios.get(
				function(response) {
					scope.clientes = response.clientes;
				}
			);
		}

		this.getSugestaoProfissionaisAssinatura = function(assinaturaId, scope){
			var urlBusca = Routing.generate('api_rest_usuario_get_sugestao_profissionais', {assinaturaId:assinaturaId});
			var Usuarios = resource(urlBusca);
			Usuarios.get(
				function(response) {
					scope.profissionais = response.profissionais;
				}
			);
		}

		this.getPerfisForm = function(scope){
			var urlPerfis = Routing.generate('api_rest_perfil_all');
			var usuarioPerfis = resource(urlPerfis);
			usuarioPerfis.get(
				function(response) {
					scope.perfis = response.perfis;
				}
			);
		}

		this.getUsuarioSituacaoForm = function(scope){
			var urlUsuarioSituacao = Routing.generate('api_rest_usuario_situacao_all');
			var usuarioSituacao = resource(urlUsuarioSituacao);
			usuarioSituacao.get(
				function(response) {
					scope.usuarioSituacao = response.usuarioSituacao;
				}
			);
		}

		this.buscaUsuariosFiltros = function(params, scope){
			var urlBusca = Routing.generate('api_rest_usuario_busca_filtros');
			var Usuarios = resource(urlBusca);
			Usuarios.get({params: params},
				function(response) {
					scope.usuarios = response.usuarios;
				}
			);
		}

		this.updateUsuario = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_admin_editar');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario}, function(response){
			 	var rota = Routing.generate('admin_usuario_index');
			         location.href = rota;
			});
		}

		this.updatePerfilProfissional = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_profissional_editar');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario},
				function(response){
                    swal(
                        "Sucesso!",
                        "Seus dados foram alterados com sucesso!",
                        "success")
                    .then(
                        function () {
						 	var rota = Routing.generate('profissional_meu_perfil');
						    location.href = rota;
						}
                    );
				},
				function(response){
					swal(
                        "Ops!",
                        "Não foi possível editar seu perfil, tente novamente ou entre em contato conosco!",
                        "error");
				}
			);
		}

		this.updatePerfilCliente = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_cliente_editar');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario},
				function(response){
                    swal(
                        "Sucesso!",
                        "Seus dados foram alterados com sucesso!",
                        "success")
                    .then(
                        function () {
						 	var rota = Routing.generate('cliente_meu_perfil');
						    location.href = rota;
						}
                    );
				},
				function(response){
					swal(
                        "Ops!",
                        "Não foi possível editar seu perfil, tente novamente ou entre em contato conosco!",
                        "error");
				}
			);
		}

		this.updateSenha = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_alterar_senha');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario},
				function(response){
                    swal(
                        "Sucesso!",
                        "Sua senha foi alterada, enviamos para seu e-mail os dados de alteração!",
                        "success");
                   	$('#modal-senha').modal('hide');
				}, function(response){
                    swal(
                        "Ops, não deu certo!",
                        "Tente novamente, se o erro persistir entre em contato conosco!",
                        "error");
				}
			);
		}

		this.uploadFotoProfissional = function (file, scope){
            var fd = new FormData();
            fd.append('file',file);

            $http.post(Routing.generate('api_rest_usuario_salvar_foto'), fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            	}
            ).then(
            	function(response){
            		alertify.success('Foto salva com sucesso!');
            	},
            	function(response){
            		console.log(response);
            	}
            );
		}

		this.alterarSituacaoUsuario = function (usuario_id, situacao_id, scope){
			var urlUpdate = Routing.generate('api_rest_usuario_admin_alterar_situacao');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario_id: usuario_id, situacao_id: situacao_id},
				function(response){
					console.log(response);
					scope.usuario.fnUsuarioSituacao = response.usuario.fnUsuarioSituacao;
				}
			);
		}

		this.updateAdminProfissional = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_admin_editar');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario}, function(response){
			 	var rota = Routing.generate('admin_usuario_profissionais');
			         location.href = rota;
			});
		}

		this.updateAdminCliente = function(usuario, scope)
		{
			var urlUpdate = Routing.generate('api_rest_usuario_admin_editar');
			var Usuario = resource(urlUpdate, null, {'update' : {method: 'PUT'}});
			Usuario.update({usuario: usuario}, function(response){
			 	var rota = Routing.generate('admin_usuario_clientes');
			         location.href = rota;
			});
		}
	}
}])
;


angular.module('easyQasaApp').requires.push('easyqasa.usuario.factory');
