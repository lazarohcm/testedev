Teste para desenvolvedor full-stack eQ!
========================

Instruções para o teste;

Sobre a aplicação
--------------

Nessa aplicação utilizamos as seguintes ferramentas:

  * PHP;

  * MySql;

  * Doctrine ORM/DBAL;

  * Composer;

  * Bower;

  * HMTL/CSS;

  * Boostrap;

  * Angular.

A aplicação já esta com a arquiterura inicial pronta e contém um CRUD incial funcionando. No index da aplicação, está o que deverá ser criado.

A arquiterura base, consiste em dois bundles:

ApiRestBundle:

  * Controller: onde estão as controllers com as rotas para todas as requisições rest;
  * Resources: as configurações da bundle. É importante o routing.yml (referencia a controller) e o services.yml (referencia ao service);
  * Service: contém o arquivo service, referente as regras de negócio das requisições.

AppBundle:

  * Controller: rotas para chamada de arquivos de interface;
  * Entity (doctrine): todas as entities da aplicação;
  * Form: todos os formulários do tipo FormType do symfony;
  * Repository (doctrine): todos os repositórios referntes a aplicação;
  * Resources: todas as views utilizadas na aplicação

Outras considerações relevantes:

* O arquivo html base, chamase base.html.twig [app/Resources/views]

* Não é necessário nenhuma importação no composer ou bower, todas as bibliotecas já estão incluídas;

* Os únicos arquivos de configuração que necessitam de alteração nesta aplicação, são:
parameters.yml [app/config]
routing.yml [ApiRestBundle/Resources/config]
services.yml [ApiRestBundle/Resources/config]


* a pasta com os arquivos angular estão em [web/assets/angular_app]

Configuração incial
--------------
  Para inciar a aplicação é necessário seguir os seguintes passos:

  * **Configuração dos paramêtros**
  Configure o arquivo parameters.yml com seus dados de acesso ao banco de dados local;

  * [**Composer**][1]
  Executar o comando composer install

  * [**Banco de dados**][2]
  Executar os comandos:
   - php bin/console doctrine:database:create (para criar o schema do banco de dados)

   - php bin/console doctrine:schema:update --force (para criar as tabelas já existentes no banco)

  * [**Configurações de rota - FOSJsRoutingBundle**][4]
    Ao executar o composer install o bundle será importado, porém ainda é necesário executar

    php bin/console assets:install --symlink web

    Obs.: sempre que for criada uma rota no ApiRestBundle, ou AppBundle é necessário rodar o comando php bin/console fos:js-routing:dump para gerar as rotas para o JS.

  * [**Bower**][3]
  Executar o comando bower install

  Obs.: No linux é necessário conseder permissão de acesso as pastas:
  /var/cache/

  /var/logs/

  /var/sessions

Dúvidas
--------------
Em caso de dúvidas, favor me envie por e-mail debora.castro@easyqasa.com

[1]:  https://getcomposer.org/
[2]:  https://symfony.com/doc/3.3/doctrine.html
[3]:  https://bower.io/
[4]:  https://symfony.com/doc/master/bundles/FOSJsRoutingBundle/installation.html