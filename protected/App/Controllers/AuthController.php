<?php

	namespace App\Controllers;

	//recursos
	use MF\Controller\Action;
	use MF\Model\Container;

	class AuthController extends Action{

		public function autenticar(){

			if(!empty($_POST['senha']) && !empty($_POST['email'])){
				$usuario = Container::getModel('Usuario');
				$usuario->__set('email', $_POST['email']);
				$usuario->__set('senha', md5($_POST['senha']));

				$usuario->autenticar();

				if ($usuario->__get('id') != '' && $usuario->__get('nome') != '' ) {

					session_start();
					$_SESSION['id'] = $usuario->__get('id');
					echo json_encode(array('success' => true, 'redirect' => 'timeline'));
				}else{
					echo json_encode(array('success' => false, 'message' => 'Usuário ou senha inválidos'));
				}
			}else{
				echo json_encode(array('success' => false, 'message' => 'Preencha os campos necessários'));
			}

		}

		public function sair(){
			session_start();
			session_destroy();
			header('location:/git_clone/TwitterClone/public/');
		}

	}

?>