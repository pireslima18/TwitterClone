<?php

	namespace App\Models;

	use MF\Model\Model;

	class Usuario extends Model{

		private $id;
		private $id_usuario_procurado;
		private $nome;
		private $email;
		private $senha;

		public function __get($atributo){
			return $this->$atributo;
		}

		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		//salvar
		public function salvar(){
			$query = 'insert into usuarios(nome,email,senha) values(:nome,:email,:senha);';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->execute();

			return $this;

		}

		//validar cadastro
		public function validarCadastro(){
			$valido = true;

			if (strlen($this->__get('nome')) < 3) {
				$valido = false;
			}
			if (strlen($this->__get('senha')) < 3) {
				$valido = false;
			}

			return $valido;
		}

		//recuperar usuario por email
		public function getUsuarioPorEmail(){

			$query = 'select nome, email from usuarios where email = :email';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}

		public function autenticar(){

			$query = 'select id, nome, email from usuarios where email = :email and senha = :senha;';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':email', $this->__get('email'));
			$stmt->bindValue(':senha', $this->__get('senha'));
			$stmt->execute();

			$usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

			if (!empty($usuario['id']) && !empty($usuario['nome'])) {
				$this->__set('id', $usuario['id']);
				$this->__set('nome', $usuario['nome']);
			}

			return $usuario;
		}

		public function getAll(){

			$query = "
			select 
				u.id,
				u.nome,
				u.email,
				(
					select
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn,
				(
					SELECT
						uf.path
					FROM
						usuarios_foto as uf
					WHERE
						id_usuario = u.id
				) as path
			from 
				usuarios as u
			where 
				u.nome like :nome
			and
				u.id != :id_usuario
			;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome', '%'.$this->__get('nome').'%');
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function verificarSeguirUsuario($id_usuario_seguindo){
			$query = "
			SELECT
				id_usuario
			FROM
				usuarios_seguidores
			WHERE
				id_usuario = :id_usuario 
			AND
				id_usuario_seguindo = :id_usuario_seguindo;
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);

		}

		public function seguirUsuario($id_usuario_seguindo){
			$query = "
			INSERT INTO 
				usuarios_seguidores(id_usuario, id_usuario_seguindo)
			VALUES
				(:id_usuario, :id_usuario_seguindo);
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
			$stmt->execute();
			return true;

		}

		public function deixarSeguirUsuario($id_usuario_seguindo){
			$query = "
			DELETE FROM 
				usuarios_seguidores 
			where 
				id_usuario = :id_usuario 
			AND 
				id_usuario_seguindo = :id_usuario_seguindo;
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_seguindo', $id_usuario_seguindo);
			$stmt->execute();

			return true;

		}

		public function getInfoUsuario(){
			$query = "
			SELECT
				nome
			FROM
				usuarios
			WHERE
				id = :id_usuario;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function getTotalTweets(){
			$query = "
			SELECT
				count(*) as total_tweets
			FROM
				tweets
			WHERE
				id_usuario = :id_usuario;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function getTotalSeguindo(){
			$query = "
			SELECT
				count(*) as total_seguindo
			FROM
				usuarios_seguidores
			WHERE
				id_usuario = :id_usuario;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function getTotalSeguidores(){
			$query = "
			SELECT
				count(*) as total_seguidores
			FROM
				usuarios_seguidores
			WHERE
				id_usuario_seguindo = :id_usuario;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function getUsuariosSeguidores(){
			//Recuperar usuários que te seguem
			$query = "
			SELECT
				u.id,
				u.nome,
				u.email,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = u.id and us.id_usuario_seguindo = :id_usuario
				) as seguidor_sn,
				(
					SELECT
						uf.path
					FROM
						usuarios_foto as uf
					WHERE
						id_usuario = u.id
				) as path
			FROM
				usuarios as u
			WHERE
				u.id != :id_usuario
			;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function getUsuariosSeguindo(){
			//Recuperar usuários que te seguem
			$query = "
			SELECT
				u.id,
				u.nome,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn,
				(
					SELECT
						uf.path
					FROM
						usuarios_foto as uf
					WHERE
						id_usuario = u.id
				) as path
			FROM
				usuarios as u
			WHERE
				u.id != :id_usuario
			;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function alterarNome(){
			$query = "
			UPDATE
				usuarios
			SET
				nome = :nome
			WHERE
				id = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':nome', $this->__get('nome'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}


		public function getUsuariosSeguidoresUsuario(){
			//Recuperar usuários que te seguem
			$query = "
			SELECT
				u.id,
				u.nome,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario_procurado and us.id_usuario_seguindo = u.id
				) as usuario_seguindo_sn,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = u.id and us.id_usuario_seguindo = :id_usuario_procurado
				) as seguidor_sn,
				(
					SELECT
						uf.path
					FROM
						usuarios_foto as uf
					WHERE
						id_usuario = u.id
				) as path
			FROM
				usuarios as u
			;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_procurado', $this->__get('id_usuario_procurado'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function getUsuariosSeguindoUsuario(){
			//Recuperar usuários que te seguem
			$query = "
			SELECT
				u.id,
				u.nome,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id
				) as seguindo_sn,
				(
					SELECT
						count(*)
					from
						usuarios_seguidores as us
					where
						us.id_usuario = :id_usuario_procurado and us.id_usuario_seguindo = u.id
				) as usuario_seguindo_sn,
				(
					SELECT
						uf.path
					FROM
						usuarios_foto as uf
					WHERE
						id_usuario = u.id
				) as path
			FROM
				usuarios as u
			;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id'));
			$stmt->bindValue(':id_usuario_procurado', $this->__get('id_usuario_procurado'));
			$stmt->execute();

			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

	}

?>