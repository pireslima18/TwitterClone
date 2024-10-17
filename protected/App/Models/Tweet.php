<?php

	namespace App\Models;

	use MF\Model\Model;

	class Tweet extends Model{

		private $id;
		private $id_usuario;
		private $id_usuario_procurado;
		private $tweet;
		private $data;

		public function __get($atributo){
			return $this->$atributo;
		}
		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		//salvar
		public function salvar(){

			$query = 'INSERT INTO tweets(id_usuario, tweet) values(:id_usuario, :tweet);';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':tweet', $this->__get('tweet'));
			$stmt->execute();

			return $this;

		}

		//recuperar somente os do usuário logado
		public function getTweetsPerfil(){

			$query = "
			SELECT 
				t.id,
				t.id_usuario,
				t.tweet,
				DATE_FORMAT(t.data, '%d/%m/%Y %H:%i')as data,
				u.nome,
                f.path,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_tweet = t.id
				) as curtidas,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_usuario = :id_usuario
					AND
						tc.id_tweet = t.id
				) as curtido_sn,
				(
					select
						count(*)
					from
						tweets_comentarios as tcm
					where
						t.id = tcm.id_tweet
				) as count_comentarios
			FROM 
				tweets as t
				left join usuarios as u on(t.id_usuario = u.id)
				left join usuarios_foto as f on(t.id_usuario = f.id_usuario)
			WHERE
				t.id_usuario = :id_usuario
			ORDER BY
				t.data desc
			;";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		//recuperar somente os do usuário procurado
		public function getTweetsUsuario(){

			$query = "
			SELECT 
				t.id,
				t.id_usuario,
				t.tweet,
				DATE_FORMAT(t.data, '%d/%m/%Y %H:%i')as data,
				u.nome,
                f.path,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_tweet = t.id
				) as curtidas,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_usuario = :id_usuario
					AND
						tc.id_tweet = t.id
				) as curtido_sn,
				(
					select
						count(*)
					from
						tweets_comentarios as tcm
					where
						t.id = tcm.id_tweet
				) as count_comentarios
			FROM 
				tweets as t
				left join usuarios as u on(t.id_usuario = u.id)
				left join usuarios_foto as f on(t.id_usuario = f.id_usuario)
			WHERE
				t.id_usuario = :id_usuario_procurado
			ORDER BY
				t.data desc
			;";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id_usuario_procurado', $this->__get('id_usuario_procurado'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		//recuperar todos
		public function getAll(){

			$query = "
			SELECT 
				t.id,
				t.id_usuario,
				t.tweet,
				DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data,
				u.nome,
                f.path,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_tweet = t.id
				) as curtidas,
                (
					select
						count(*)
					from
						tweets_curtidas as tc
					where
						tc.id_usuario = :id_usuario
					AND
						tc.id_tweet = t.id
				) as curtido_sn,
				(
					select
						count(*)
					from
						tweets_comentarios as tcm
					where
						t.id = tcm.id_tweet
				) as count_comentarios
			FROM 
				tweets as t
				left join usuarios as u on(t.id_usuario = u.id)
				left join usuarios_foto as f on(t.id_usuario = f.id_usuario)
			WHERE 
				t.id_usuario = :id_usuario
			OR 
				t.id_usuario in (
					SELECT
						id_usuario_seguindo
					from
						usuarios_seguidores
					where
						id_usuario = :id_usuario
				)
			ORDER BY
				t.data desc
			;";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function verificarIdExclusao(){
			$query = "SELECT id FROM tweets WHERE id_usuario = :id_usuario AND id = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function excluirTweet(){
			$query = "DELETE FROM tweets WHERE id = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function excluirTweetCurtidas(){
			$query = "DELETE FROM tweets_curtidas WHERE id_tweet = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function curtirTweet(){
			$query = "
			INSERT INTO
				tweets_curtidas(id_usuario, id_tweet)
			VALUES
				(:id_usuario, :id);
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function descurtirTweet(){
			$query = "DELETE FROM tweets_curtidas WHERE id_usuario = :id_usuario AND id_tweet = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

	}

?>