<?php

	namespace App\Models;

	use MF\Model\Model;

	class Comentario extends Model{

		private $id;
		private $id_usuario;
		private $comentario;
		private $data;

		public function __get($atributo){
			return $this->$atributo;
		}
		public function __set($atributo, $valor){
			$this->$atributo = $valor;
		}

		//salvar
		public function salvar(){

			$query = '
			INSERT INTO 
				tweets_comentarios(id_usuario, id_tweet, comentario)
			values
				(:id_usuario, :id_tweet, :comentario);
			';
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id_tweet', $this->__get('id_tweet'));
			$stmt->bindValue(':comentario', $this->__get('comentario'));
			$stmt->execute();

			return $this;

		}

		//recuperar todos
		public function getAll(){

			$query = "
			SELECT 
				c.id,
				c.id_usuario,
				c.id_tweet,
				c.comentario,
				DATE_FORMAT(c.data, '%d/%m/%Y %H:%i') as data,
				u.nome,
                f.path,
                (
					select
						count(*)
					from
						comentarios_curtidas as cc
					where
						cc.id_comentario = c.id
				) as curtidas,
                (
					select
						count(*)
					from
						comentarios_curtidas as cc
					where
						cc.id_usuario = :id_usuario
					AND
						cc.id_comentario = c.id
				) as curtido_sn
			FROM 
				tweets_comentarios as c
				left join usuarios as u on(c.id_usuario = u.id)
				left join usuarios_foto as f on(c.id_usuario = f.id_usuario)
			WHERE
				c.id_tweet = :id_tweet
			ORDER BY
				c.data asc
			;";

			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id_tweet', $this->__get('id_tweet'));
			$stmt->execute();
			return $stmt->fetchAll(\PDO::FETCH_ASSOC);

		}

		public function verificarIdExclusao(){
			$query = "SELECT id FROM tweets_comentarios WHERE id_usuario = :id_usuario AND id = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function excluirComentario(){
			$query = "DELETE FROM tweets_comentarios WHERE id = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function excluirComentarioCurtidas(){
			$query = "DELETE FROM comentarios_curtidas WHERE id_comentario = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();
			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function curtirComentario(){
			$query = "
			INSERT INTO
				comentarios_curtidas(id_usuario, id_comentario)
			VALUES
				(:id_usuario, :id);
			";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

		public function descurtirComentario(){
			$query = "DELETE FROM comentarios_curtidas WHERE id_usuario = :id_usuario AND id_comentario = :id;";
			$stmt = $this->db->prepare($query);
			$stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
			$stmt->bindValue(':id', $this->__get('id'));
			$stmt->execute();

			return $stmt->fetch(\PDO::FETCH_ASSOC);
		}

	}

?>