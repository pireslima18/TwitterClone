<?php

	namespace App\Models;

	use MF\Model\Model;

	class Foto extends Model{

		private $id;
		private $id_usuario;
		private $nome;
		private $path;
		private $error;
		private $data;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		//verificar existencia upload
		public function verificarFotoExistente(){
			$query = 'select id from usuarios_foto where id_usuario = :id_usuario;';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);

		}

		//recuperar path upload
		public function recuperarPath(){
			$query = "select path from usuarios_foto where id_usuario = :id_usuario";
			$stmt =  $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_OBJ);

		}

		//excluir upload
		public function excluirFoto(){
			$query = "delete from usuarios_foto where id_usuario = :id_usuario";
			$stmt =  $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_OBJ);

		}

		//salvar
		public function salvarFoto(){
			$query = 'insert into usuarios_foto(id_usuario,nome,path) values(:id_usuario,:nome,:path);';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':path', $this->__get('path'));
			$stmt->execute();

			return $this;

		}

		//recuperar foto
		public function recuperarFoto(){
			$query = 'select path from usuarios_foto where id_usuario = :id_usuario;';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_OBJ);

		}

	}

?>