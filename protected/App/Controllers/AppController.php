<?php

	namespace App\Controllers;

	//recursos
	use MF\Controller\Action;
	use MF\Model\Container;

	class AppController extends Action{

		public function timeline(){

			$this->validaAutenticacao();

			//$_SESSION['path'] = $this->recuperarFoto($_SESSION['id']);

			//recuperar dados do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$this->view->info_usuario = $usuario->getInfoUsuario();
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			$this->render('timeline');
		
		}

		public function tweets(){

			$this->validaAutenticacao();

			//recuperação dos tweets
			$tweet = Container::getModel('Tweet');
			$tweet->__set('id_usuario', $_SESSION['id']);

			$tweets = $tweet->getAll();

			$this->view->tweets = $tweets;

			//$this->render('tweets');
			$this->require('tweets');
		}

		public function tweet(){

			$this->validaAutenticacao();
			
			$tweet = Container::getModel('Tweet');

            $tweetText = filter_var($_POST['tweet'], FILTER_SANITIZE_STRING);
			$tweet->__set('tweet', $tweetText);
			$tweet->__set('id_usuario', $_SESSION['id']);

			$tweet->salvar();

			//header('location: timeline');
			//$this->render('tweets');
			echo json_encode(true);

		}

		public function recuperarComentario(){

			$this->validaAutenticacao();
			
			$comentario = Container::getModel('Comentario');

			$comentario->__set('id_tweet', $_GET['id_tweet']);
			$comentario->__set('id_usuario', $_SESSION['id']);

			$comentarios = $comentario->getAll();

			$this->view->comentarios = $comentarios;

			//$this->render('comentarios');
			$this->require('comentarios');
		}

		public function comentario(){

			$this->validaAutenticacao();
			
			$comentario = Container::getModel('Comentario');

			if($_POST['comentario'] != ""){
				$comentario->__set('comentario', $_POST['comentario']);
				$comentario->__set('id_tweet', $_POST['id_tweet']);
				$comentario->__set('id_usuario', $_SESSION['id']);

				$comentario->salvar();

				echo json_encode(true);
			}


		}

		public function removerTweet(){

			$this->validaAutenticacao();
			
			$tweet = Container::getModel('Tweet');

			$tweet->__set('id_usuario', $_SESSION['id']);
			$tweet->__set('id', $_GET['id_tweet']);

			$controle = $tweet->verificarIdExclusao();
			if ($controle != '') {
				$tweet->excluirTweet();
				$tweet->excluirTweetCurtidas();
				//header('location: perfil');
			}else{
				header('location: perfil');
			}
			
		}

		public function removerComentario(){

			$this->validaAutenticacao();
			
			$comentario = Container::getModel('comentario');

			$comentario->__set('id_usuario', $_SESSION['id']);
			$comentario->__set('id', $_GET['id_comentario']);

			$controle = $comentario->verificarIdExclusao();
			if ($controle != '') {
				$comentario->excluirComentario();
				$comentario->excluirComentarioCurtidas();
			}else{
			}
			
		}

		public function quemSeguir(){

			$this->validaAutenticacao();

			//$_SESSION['path'] = $this->recuperarFoto($_SESSION['id']);

			//recuperar informações do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$this->view->info_usuario = $usuario->getInfoUsuario();
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			$this->render('quemSeguir');
		}

		public function pesquisarUsuarios(){

			$this->validaAutenticacao();

			$pesquisarPor = isset($_GET['pesquisarPor']) ? $_GET['pesquisarPor'] : '';

			$this->view->nome_usuario = '';

			$usuarios = array();

			//recuperar usuários que correspondem à busca
			if ($pesquisarPor != '') {
				$usuario = Container::getModel('Usuario');
				$usuario->__set('nome', $pesquisarPor);
				$usuario->__set('id', $_SESSION['id']);
				$usuarios = $usuario->getAll();
				$this->view->nome_usuario = $_GET['pesquisarPor'];
			}

			$this->view->usuarios = $usuarios;

			$this->render('pesquisarUsuarios');
		}

		public function perfil(){

			$this->validaAutenticacao();

			//definir path da foto do usuário
			$_SESSION['path'] = $this->recuperarFoto($_SESSION['id']);
			
			//recuperar informações do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$_SESSION['nome'] = $usuario->getInfoUsuario()['nome'];

			//$this->view->info_usuario = $usuario->getInfoUsuario();
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			$this->render('perfil');

		}

		public function perfilTweets(){

			$this->validaAutenticacao();

			//recuperar informações do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//recuperação dos tweets
			$tweet = Container::getModel('Tweet');
			$tweet->__set('id_usuario', $_SESSION['id']);
			$tweets = $tweet->getTweetsPerfil();

			$this->view->tweets = $tweets;
			
			//$this->render('perfilTweets');
			$this->require('perfilTweets');
		}

		public function perfilSeguidores(){

			$this->validaAutenticacao();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//Recuperar seguidores
			$usuarios = array();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$usuarios = $usuario->getUsuariosSeguidores();

			$this->view->usuarios = $usuarios;

			//$this->render('perfilSeguidores');
			$this->require('perfilSeguidores');

		}

		public function perfilSeguindo(){

			$this->validaAutenticacao();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$this->view->info_usuario = $usuario->getInfoUsuario();
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//Recuperar seguidores
			$usuarios = array();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$usuarios = $usuario->getUsuariosSeguindo();

			$this->view->usuarios = $usuarios;

			//$this->render('perfilSeguindo');
			$this->require('perfilSeguindo');

		}

		public function usuarioPerfil(){

			$this->validaAutenticacao();

			//recuperar informações do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_GET['usuario']);

			//verificar se usuário pesquisado é válido
			if($usuario->getInfoUsuario() != ''){
				$this->view->nome_usuario = $usuario->getInfoUsuario()['nome'];
				$this->view->total_tweets = $usuario->getTotalTweets();
				$this->view->total_seguindo = $usuario->getTotalSeguindo();
				$this->view->total_seguidores = $usuario->getTotalSeguidores();

				//Verificar se estar seguindo ou não
				$usuario_principal = Container::getModel('Usuario');
				$usuario_principal->__set('id', $_SESSION['id']);
				$this->view->seguindo_sn = $usuario_principal->verificarSeguirUsuario($_GET['usuario']);

				//definir path da foto do usuário
				$this->view->foto = $this->recuperarFoto($_GET['usuario']);

				$this->render('usuarioPerfil');
			}else{
				$this->render('usuarioPerfil');
			}

		}

		public function usuarioTweets(){

			$this->validaAutenticacao();

			//recuperar informações do usuário
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_GET['usuario']);
			
			$this->view->nome_usuario = $usuario->getInfoUsuario()['nome'];
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//recuperação dos tweets
			$tweet = Container::getModel('Tweet');
			$tweet->__set('id_usuario', $_SESSION['id']);
			$tweet->__set('id_usuario_procurado', $_GET['usuario']);
			$tweets = $tweet->getTweetsUsuario();

			$this->view->tweets = $tweets;
			
			//$this->render('usuarioTweets');
			$this->require('usuarioTweets');
		}


		public function usuarioSeguidores(){

			$this->validaAutenticacao();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_GET['usuario']);

			$this->view->nome_usuario = $usuario->getInfoUsuario()['nome'];
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//Recuperar seguidores
			$usuarios = array();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$usuario->__set('id_usuario_procurado', $_GET['usuario']);
			$usuarios = $usuario->getUsuariosSeguidoresUsuario();

			$this->view->usuarios = $usuarios;

			//$this->render('ususarioSeguidores');
			$this->require('usuarioSeguidores');

		}

		public function usuarioSeguindo(){

			$this->validaAutenticacao();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_GET['usuario']);
			
			$this->view->nome_usuario = $usuario->getInfoUsuario()['nome'];
			$this->view->total_tweets = $usuario->getTotalTweets();
			$this->view->total_seguindo = $usuario->getTotalSeguindo();
			$this->view->total_seguidores = $usuario->getTotalSeguidores();

			//Recuperar seguidores
			$usuarios = array();
			
			$usuario = Container::getModel('Usuario');
			$usuario->__set('id', $_SESSION['id']);
			$usuario->__set('id_usuario_procurado', $_GET['usuario']);
			$usuarios = $usuario->getUsuariosSeguindoUsuario();

			$this->view->usuarios = $usuarios;

			//$this->render('usuarioSeguindo');
			$this->require('usuarioSeguindo');

		}

		public function editarPerfil(){

			$this->validaAutenticacao();

			try{
				if(isset($_POST['arquivo'])){
					$foto = Container::getModel('Foto');

					//receber imagem
					$imagem = filter_input(INPUT_POST, 'arquivo', FILTER_DEFAULT);

					if($imagem != null){
						$foto->__set('id_usuario', $_SESSION['id']);

						//separar as informações da imagem base64
						list($type, $imagem) = explode(';', $imagem);

						list(, $imagem) = explode(',', $imagem);

						//desconverter a imagem base64
						$imagem = base64_decode($imagem);

						//atribuir a extensão da imagem PNG
						$imagem_nome = time() . '.png';

						$salvarFoto = file_put_contents('fotos_usuarios/' . $imagem_nome, $imagem);

						$nomeDoArquivo = $imagem_nome;

						//verificando existencia de foto
						if($salvarFoto){
							if($foto->verificarFotoExistente() > 0){
								$path_arquivo = $foto->recuperarPath();

								//if(unlink($path_arquivo->path)){
								unlink($path_arquivo->path);
								
								$foto->excluirFoto();

								//definindo lugar de salvamento
								$path = 'fotos_usuarios/' . $imagem_nome;
								$move_file = file_put_contents('fotos_usuarios/' . $imagem_nome, $imagem);

								if($move_file == true){

									$foto->__set('nome', $nomeDoArquivo);
									$foto->__set('path', $path);

									$foto->salvarFoto();

									$_SESSION['path'] = $foto->__get('path');
								}else{
								  	//header('location: perfil?error=1');
								  	echo json_encode("erro");
								}
							}
							else{

								//definindo lugar de salvamento
								$path = 'fotos_usuarios/' . $imagem_nome;
								$move_file = file_put_contents('fotos_usuarios/' . $imagem_nome, $imagem);

								if($move_file == true){

									$foto->__set('nome', $nomeDoArquivo);
									$foto->__set('path', $path);

									$foto->salvarFoto();
								}else{
								  	echo json_encode("erro");
								}
							}
						}
					}else{
						header('location: perfil?erro=1');
					}

					$foto->__set('id_usuario', $_SESSION['id']);
				}

				if(isset($_POST['nome'])){
					$usuario = Container::getModel('Usuario');
					$usuario->__set('id', $_SESSION['id']);
					$usuario->__set('nome', $_POST['nome']);

					$usuario->alterarNome();

					$_SESSION['nome'] = $usuario->__get('nome');
					//$this->view->teste = $usuario;
				}

			} finally {
				echo json_encode("done");
			}

		}

		public function acao(){

			$this->validaAutenticacao();

			$acao = isset($_GET['acao']) ? $_GET['acao'] : '';

			if($acao == 'seguir' || $acao == 'deixar_de_seguir'){
				$id_usuario_seguindo = isset($_GET['id_usuario']) ? $_GET['id_usuario'] : '';

				$usuario = Container::getModel('Usuario');
				$usuario->__set('id', $_SESSION['id']);

				if ($acao == 'seguir') {
					if(empty($usuario->verificarSeguirUsuario($id_usuario_seguindo))){
						$usuario->seguirUsuario($id_usuario_seguindo);
					}
				}elseif ($acao == 'deixar_de_seguir') {
					if(!empty($usuario->verificarSeguirUsuario($id_usuario_seguindo))){
						$usuario->deixarSeguirUsuario($id_usuario_seguindo);
					}
				}

				header('location: quem_seguir?pesquisarPor='.$_GET['pesquisarPor']);
			} elseif($acao == 'curtirTweet' || $acao == 'descurtirTweet'){
				
				$tweet = Container::getModel('Tweet');
				$tweet->__set('id_usuario', $_SESSION['id']);
				$tweet->__set('id', $_GET['id_tweet']);

				if ($acao == 'curtirTweet') {
					$tweet->curtirTweet();
				}elseif ($acao == 'descurtirTweet') {
					$tweet->descurtirTweet();
				}
			} elseif($acao == 'curtirComentario' || $acao == 'descurtirComentario'){
				
				$comentario = Container::getModel('comentario');
				$comentario->__set('id_usuario', $_SESSION['id']);
				$comentario->__set('id', $_GET['id_comentario']);

				if ($acao == 'curtirComentario') {
					$comentario->curtirComentario();
				}elseif ($acao == 'descurtirComentario') {
					$comentario->descurtirComentario();
				}
			}

		}

		public function recuperarFoto($id){

			$foto = Container::getModel('Foto');
			$foto->__set('id_usuario', $id);

			$foto->recuperarFoto();

			if(empty($foto->recuperarFoto()->path)){
				return 'fotos_usuarios/sem_foto.png';
			}else{
				$path =  $foto->recuperarFoto()->path;

				return $path;
			}

		}

		public function validaAutenticacao(){

			session_start();

			if (!isset($_SESSION['id']) || $_SESSION['id'] == '' /*|| !isset($_SESSION['nome']) || $_SESSION['nome'] == ''*/) {
				
				header('location: /projeto/projeto_8/?login=erro');

			}

		}

	}

?>