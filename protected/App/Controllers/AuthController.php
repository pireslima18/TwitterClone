<?php

	namespace App\Controllers;

	//recursos
	use MF\Controller\Action;
	use MF\Model\Container;

	class AuthController extends Action{

		public function autenticar(){

			$usuario = Container::getModel('Usuario');

			$usuario->__set('email', $_POST['email']);
			$usuario->__set('senha', md5($_POST['senha']));

			$usuario->autenticar();

			if ($usuario->__get('id') != '' && $usuario->__get('nome') != '' ) {

				session_start();
				$_SESSION['id'] = $usuario->__get('id');
				//$_SESSION['nome'] = $usuario->__get('nome');
				header('Location: timeline');

			}else{
				header('Location: /site_suamelhorface/projeto/projeto_8/?login=erro');
			}

		}

		public function sair(){
			session_start();
			session_destroy();
			header('location:/site_suamelhorface/projeto/projeto_8/');
		}

	}

?>