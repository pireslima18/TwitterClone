<?php

	namespace App\Controllers;

	//recursos
	use MF\Controller\Action;
	use MF\Model\Container;

	class IndexController extends Action{

		public function index(){

			if(isset($_GET['cadastro']) && $_GET['cadastro'] == 'success'){
				$this->view->cadastro = $_GET['cadastro'];
			}
			$this->render('index');
		}

		public function inscreverse(){

			$this->view->erroCadastro = false;
			
			$this->render('inscreverse');

		}

		public function registrar(){

			if(!empty($_POST['nome']) && !empty($_POST['email']) && !empty($_POST['senha'])){
				$usuario = Container::getModel('Usuario');
				$usuario->__set('nome', $_POST['nome']);
				$usuario->__set('email', $_POST['email']);
				$usuario->__set('senha', md5($_POST['senha']));

				if ($usuario->validarCadastro() && count($usuario->getUsuarioPorEmail()) == 0) {
						
						$usuario->salvar();
	
						echo json_encode(array('success' => true, 'redirect' => '/projeto/projeto_8/?cadastro=success'));
				}else{

					echo json_encode(array('success' => false, 'message' => 'Usuário já cadastrado'));
				}
			}else{
				echo json_encode(array('success' => false, 'message' => 'Preencha os campos necessários'));
			}

		}

	}

?>