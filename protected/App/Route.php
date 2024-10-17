<?php
	
	namespace App;

	use MF\Init\Bootstrap;

	class Route extends Bootstrap{

		public function initRoutes(){

			$routes['home'] = array(
				'route' => '/git_clone/TwitterClone/public/',
				'controller' => 'indexController',
				'action' => 'index'
			);
			$routes['inscreverse'] = array(
				'route' => '/git_clone/TwitterClone/public/inscreverse',
				'controller' => 'indexController',
				'action' => 'inscreverse'
			);
			$routes['registrar'] = array(
				'route' => '/git_clone/TwitterClone/public/registrar',
				'controller' => 'indexController',
				'action' => 'registrar'
			);
			$routes['autenticar'] = array(
				'route' => '/git_clone/TwitterClone/public/autenticar',
				'controller' => 'AuthController',
				'action' => 'autenticar'
			);
			$routes['sair'] = array(
				'route' => '/git_clone/TwitterClone/public/sair',
				'controller' => 'AuthController',
				'action' => 'sair'
			);
			$routes['timeline'] = array(
				'route' => '/git_clone/TwitterClone/public/timeline',
				'controller' => 'AppController',
				'action' => 'timeline'
			);
			$routes['tweets'] = array(
				'route' => '/git_clone/TwitterClone/public/tweets',
				'controller' => 'AppController',
				'action' => 'tweets'
			);
			$routes['tweet'] = array(
				'route' => '/git_clone/TwitterClone/public/tweet',
				'controller' => 'AppController',
				'action' => 'tweet'
			);
			$routes['recuperar_comentario'] = array(
				'route' => '/git_clone/TwitterClone/public/recuperar_comentario',
				'controller' => 'AppController',
				'action' => 'recuperarComentario'
			);
			$routes['comentario'] = array(
				'route' => '/git_clone/TwitterClone/public/comentario',
				'controller' => 'AppController',
				'action' => 'comentario'
			);
			$routes['remover_tweet'] = array(
				'route' => '/git_clone/TwitterClone/public/remover_tweet',
				'controller' => 'AppController',
				'action' => 'removerTweet'
			);
			$routes['remover_comentario'] = array(
				'route' => '/git_clone/TwitterClone/public/remover_comentario',
				'controller' => 'AppController',
				'action' => 'removerComentario'
			);
			$routes['quem_seguir'] = array(
				'route' => '/git_clone/TwitterClone/public/quem_seguir',
				'controller' => 'AppController',
				'action' => 'quemSeguir'
			);
			$routes['pesquisar_usuarios'] = array(
				'route' => '/git_clone/TwitterClone/public/pesquisar_usuarios',
				'controller' => 'AppController',
				'action' => 'pesquisarUsuarios'
			);
			$routes['perfil'] = array(
				'route' => '/git_clone/TwitterClone/public/perfil',
				'controller' => 'AppController',
				'action' => 'perfil'
			);
			$routes['perfilTweets'] = array(
				'route' => '/git_clone/TwitterClone/public/perfilTweets',
				'controller' => 'AppController',
				'action' => 'perfilTweets'
			);
			$routes['perfilSeguidores'] = array(
				'route' => '/git_clone/TwitterClone/public/perfilSeguidores',
				'controller' => 'AppController',
				'action' => 'perfilSeguidores'
			);
			$routes['perfilSeguindo'] = array(
				'route' => '/git_clone/TwitterClone/public/perfilSeguindo',
				'controller' => 'AppController',
				'action' => 'perfilSeguindo'
			);
			$routes['novaFoto'] = array(
				'route' => '/git_clone/TwitterClone/public/novaFoto',
				'controller' => 'AppController',
				'action' => 'novaFoto'
			);
			$routes['alterarNome'] = array(
				'route' => '/git_clone/TwitterClone/public/alterarNome',
				'controller' => 'AppController',
				'action' => 'alterarNome'
			);
			$routes['acao'] = array(
				'route' => '/git_clone/TwitterClone/public/acao',
				'controller' => 'AppController',
				'action' => 'acao'
			);

			$this->setRoutes($routes);
		}

	}

?>