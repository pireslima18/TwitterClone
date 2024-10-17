<?php
	
	namespace App;

	use MF\Init\Bootstrap;

	class Route extends Bootstrap{

		public function initRoutes(){

			$routes['home'] = array(
				'route' => '/projeto/projeto_8/',
				'controller' => 'indexController',
				'action' => 'index'
			);
			$routes['inscreverse'] = array(
				'route' => '/projeto/projeto_8/inscreverse',
				'controller' => 'indexController',
				'action' => 'inscreverse'
			);
			$routes['registrar'] = array(
				'route' => '/projeto/projeto_8/registrar',
				'controller' => 'indexController',
				'action' => 'registrar'
			);
			$routes['autenticar'] = array(
				'route' => '/projeto/projeto_8/autenticar',
				'controller' => 'AuthController',
				'action' => 'autenticar'
			);
			$routes['sair'] = array(
				'route' => '/projeto/projeto_8/sair',
				'controller' => 'AuthController',
				'action' => 'sair'
			);
			$routes['timeline'] = array(
				'route' => '/projeto/projeto_8/timeline',
				'controller' => 'AppController',
				'action' => 'timeline'
			);
			$routes['tweets'] = array(
				'route' => '/projeto/projeto_8/tweets',
				'controller' => 'AppController',
				'action' => 'tweets'
			);
			$routes['tweet'] = array(
				'route' => '/projeto/projeto_8/tweet',
				'controller' => 'AppController',
				'action' => 'tweet'
			);
			$routes['recuperar_comentario'] = array(
				'route' => '/projeto/projeto_8/recuperar_comentario',
				'controller' => 'AppController',
				'action' => 'recuperarComentario'
			);
			$routes['comentario'] = array(
				'route' => '/projeto/projeto_8/comentario',
				'controller' => 'AppController',
				'action' => 'comentario'
			);
			$routes['remover_tweet'] = array(
				'route' => '/projeto/projeto_8/remover_tweet',
				'controller' => 'AppController',
				'action' => 'removerTweet'
			);
			$routes['remover_comentario'] = array(
				'route' => '/projeto/projeto_8/remover_comentario',
				'controller' => 'AppController',
				'action' => 'removerComentario'
			);
			$routes['quem_seguir'] = array(
				'route' => '/projeto/projeto_8/quem_seguir',
				'controller' => 'AppController',
				'action' => 'quemSeguir'
			);
			$routes['pesquisar_usuarios'] = array(
				'route' => '/projeto/projeto_8/pesquisar_usuarios',
				'controller' => 'AppController',
				'action' => 'pesquisarUsuarios'
			);
			$routes['perfil'] = array(
				'route' => '/projeto/projeto_8/perfil',
				'controller' => 'AppController',
				'action' => 'perfil'
			);
			$routes['perfilTweets'] = array(
				'route' => '/projeto/projeto_8/perfilTweets',
				'controller' => 'AppController',
				'action' => 'perfilTweets'
			);
			$routes['perfilSeguidores'] = array(
				'route' => '/projeto/projeto_8/perfilSeguidores',
				'controller' => 'AppController',
				'action' => 'perfilSeguidores'
			);
			$routes['perfilSeguindo'] = array(
				'route' => '/projeto/projeto_8/perfilSeguindo',
				'controller' => 'AppController',
				'action' => 'perfilSeguindo'
			);
			$routes['usuarioPerfil'] = array(
				'route' => '/projeto/projeto_8/usuarioPerfil',
				'controller' => 'AppController',
				'action' => 'usuarioPerfil'
			);
			$routes['usuarioTweets'] = array(
				'route' => '/projeto/projeto_8/usuarioTweets',
				'controller' => 'AppController',
				'action' => 'usuarioTweets'
			);
			$routes['usuarioSeguidores'] = array(
				'route' => '/projeto/projeto_8/usuarioSeguidores',
				'controller' => 'AppController',
				'action' => 'usuarioSeguidores'
			);
			$routes['usuarioSeguindo'] = array(
				'route' => '/projeto/projeto_8/usuarioSeguindo',
				'controller' => 'AppController',
				'action' => 'usuarioSeguindo'
			);
			$routes['editarPerfil'] = array(
				'route' => '/projeto/projeto_8/editarPerfil',
				'controller' => 'AppController',
				'action' => 'editarPerfil'
			);
			$routes['acao'] = array(
				'route' => '/projeto/projeto_8/acao',
				'controller' => 'AppController',
				'action' => 'acao'
			);

			$this->setRoutes($routes);
		}

	}

?>